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

        return view('reports.index', compact('transactions', 'users'));
    }

    public function xls()
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
        
        return $transactions;
    }

    public function pdf()
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
        
        return $transactions;
    }
}
