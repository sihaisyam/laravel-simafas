<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\RentalDetail;
use App\Models\RentalTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class RentalTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = RentalTransaction::when(request()->search, function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%')
                  ->orWhere('phone', 'like', '%' . request()->search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('rental-transactions.index', compact('transactions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facilities = Facility::all(); // Assuming you have a Facility model
        return view('rental-transactions.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'total_biaya' => 'required|numeric|min:0',
            'facilities' => 'required|array|min:1',
            'facilities.*.facility_id' => 'required|exists:facilities,id',
            'facilities.*.durasi_jam' => 'required|integer|min:1',
            'facilities.*.tanggal_mulai' => 'required|date',
            'facilities.*.tanggal_selesai' => 'required|date',
            'facilities.*.harga_per_jam' => 'required|numeric|min:0',
            'facilities.*.sub_total' => 'required|numeric|min:0',
            'facilities.*.catatan_tambahan' => 'nullable|string|max:500'
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // 1. Create main transaction
            $transaction = RentalTransaction::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'total_biaya' => $validated['total_biaya'],
                'kasir_id' => Auth::user()->id,
                'status_pembayaran' => 'PENDING'
            ]);

            // 2. Create rental details
            foreach ($validated['facilities'] as $facilityData) {
                $facility = Facility::findOrFail($facilityData['facility_id']);
                
                RentalDetail::create([
                    'rental_transaction_id' => $transaction->id,
                    'facility_id' => $facilityData['facility_id'],
                    'durasi_jam' => $facilityData['durasi_jam'],
                    'tanggal_mulai' => $facilityData['tanggal_mulai'],
                    'tanggal_selesai' => $facilityData['tanggal_selesai'],
                    'catatan_tambahan' => $facilityData['catatan_tambahan'] ?? null,
                    'harga_per_jam' =>$facilityData['harga_per_jam'], // Jika perlu menyimpan harga saat itu
                    'sub_total' => $facilityData['sub_total'],
                ]);
            }
            // Commit transaksi jika semua sukses
            DB::commit();

            return redirect()->route('rental-transactions.index')
                ->with('success', 'Transaksi berhasil dibuat!');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalTransaction $rentalTransaction)
    {
        return view('rental-transactions.show', compact('rentalTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalTransaction $rentalTransaction)
    {
        $facilities = Facility::all();
        $rentalTransaction->load('rentalDetails.facility');
        
        return view('rental-transactions.edit', [
            'transaction' => $rentalTransaction,
            'facilities' => $facilities
        ]);
    }

    public function update(Request $request, RentalTransaction $rentalTransaction)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'total_biaya' => 'required|numeric|min:0',
            'facilities' => 'required|array|min:1',
            'facilities.*.id' => 'nullable|exists:rental_details,id,rental_transaction_id,'.$rentalTransaction->id,
            'facilities.*.facility_id' => 'required|exists:facilities,id',
            'facilities.*.durasi_jam' => 'required|integer|min:1',
            'facilities.*.tanggal_mulai' => 'required|date',
            'facilities.*.tanggal_selesai' => 'required|date',
            'facilities.*.catatan_tambahan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Update main transaction
            $rentalTransaction->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'total_biaya' => $validated['total_biaya']
            ]);

            // Get current detail IDs to detect deletions
            $currentDetailIds = $rentalTransaction->rentalDetails->pluck('id')->toArray();
            $updatedDetailIds = [];

            // Process each facility
            foreach ($validated['facilities'] as $facilityData) {
                $facility = Facility::findOrFail($facilityData['facility_id']);
                
                if (isset($facilityData['id'])) {
                    // Update existing detail
                    $detail = RentalDetail::findOrFail($facilityData['id']);
                    $detail->update([
                        'facility_id' => $facilityData['facility_id'],
                        'durasi_jam' => $facilityData['durasi_jam'],
                        'tanggal_mulai' => $facilityData['tanggal_mulai'],
                        'tanggal_selesai' => $facilityData['tanggal_selesai'],
                        'catatan_tambahan' => $facilityData['catatan_tambahan'] ?? null,
                        // 'harga_per_jam' => $facility->price_per_hour
                    ]);
                    $updatedDetailIds[] = $facilityData['id'];
                } else {
                    // Create new detail
                    RentalDetail::create([
                        'rental_transaction_id' => $rentalTransaction->id,
                        'facility_id' => $facilityData['facility_id'],
                        'durasi_jam' => $facilityData['durasi_jam'],
                        'tanggal_mulai' => $facilityData['tanggal_mulai'],
                        'tanggal_selesai' => $facilityData['tanggal_selesai'],
                        'catatan_tambahan' => $facilityData['catatan_tambahan'] ?? null,
                        // 'harga_per_jam' => $facility->price_per_hour
                    ]);
                }
            }

            // Delete details that were removed
            $detailsToDelete = array_diff($currentDetailIds, $updatedDetailIds);
            if (!empty($detailsToDelete)) {
                RentalDetail::whereIn('id', $detailsToDelete)->delete();
            }

            DB::commit();

            return redirect()->route('rental-transactions.index')
                ->with('success', 'Transaction updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update transaction: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalTransaction $rentalTransaction)
    {
        try {
            $rentalTransaction->delete();
            return redirect()->route('rental-transactions.index')
                ->with('success', 'Transaction for '.$rentalTransaction->name.' has been deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function print(Request $request, RentalTransaction $rentalTransaction)
    {
        $pdf = PDF::loadview('rental-transactions.print-pdf',
        ['data'=> $rentalTransaction]);
    	return $pdf->stream('print-pdf');
    }
}