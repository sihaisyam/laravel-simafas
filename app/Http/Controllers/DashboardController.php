<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\RentalTransaction;
use App\Models\Facility;
use App\Models\Category;
use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;
use marineusde\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::count();
        $facilities = Facility::count();
        $categories = Category::count();
        $transactions = RentalTransaction::count();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
        $data = [65, 59, 80, 81, 56, 55];

        $chart = (new LarapexChart)
        ->setTitle('Total Users Monthly')
        // ->setSubtitle('From January to March')
        ->setLabels([
            'Jan', 'Feb', 'Mar'
        ])
        // ->addLine('Active Users', [250, 700, 1200])
        // ->setXAxis([
        //     'Jan', 'Feb', 'Mar'
        // ])
        ->setColors(['#ffc63b', '#ff6384','#ffa377' ])
        ->setDataset([250, 700, 1200]);

        $muc = new MonthlyUsersChart();
        $chartL = $muc->build();

        return view('dashboard', compact('users', 'facilities', 'categories','transactions', 'labels', 'data', 'chart', 'chartL'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
