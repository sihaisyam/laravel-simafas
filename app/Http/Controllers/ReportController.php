<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentalTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = [];
        $users = User::all();

        if(request()->startDate && request()->endDate && request()->kasir_id){
            $transactions = RentalTransaction::where('kasir_id', request()->kasir_id)->whereBetween('created_at', [request()->startDate, request()->endDate])
            ->get();
        }else if (request()->startDate && request()->endDate) {
            $transactions = RentalTransaction::whereBetween('created_at', [request()->startDate, request()->endDate])
            ->get();
        }else if(request()->kasir_id){
            $transactions = RentalTransaction::where('kasir_id', request()->kasir_id)->get();
        } 
        // $transactions = RentalTransaction::when(request()->search, function ($query) {
        //     $query->where('name', 'like', '%' . request()->search . '%')
        //           ->orWhere('phone', 'like', '%' . request()->search . '%');
        // })->orderBy('created_at', 'desc')->paginate(10);

        return view('reports.index', compact('transactions', 'users'));
    }

    public function xls()
    {

    }

    public function pdf()
    {

    }
}
