<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::when(request()->search, function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%');
        })->paginate(10);

        return view('payment-methods.index', compact('paymentMethods'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
        ]);

        try {
            $paymentMethod = PaymentMethod::create($request->all());

            return redirect()->route('payment-methods.index')
                ->with('success', 'Payment method ' . $paymentMethod->name . ' has been added successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
        ]);

        try {
            $paymentMethod->update($request->all());

            return redirect()->route('payment-methods.index')
                ->with('success', 'Payment method ' . $paymentMethod->name . ' has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->delete();

            return redirect()->route('payment-methods.index')
                ->with('success', 'Payment method ' . $paymentMethod->name . ' has been deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
