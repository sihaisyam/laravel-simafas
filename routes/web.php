<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RentalTransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('users/export-xls',[ UserController::class, 'exportExcel'])->name('users.export-xls');
    Route::resource('users', UserController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('facilities/laporan-pdf',[ FacilityController::class, 'reportPdf'])->name('facilities.report-pdf');
    Route::resource('facilities', FacilityController::class);

    Route::resource('payment-methods', PaymentMethodController::class);
    
    Route::get('rental-transactions/{rentalTransaction}/print', [RentalTransactionController::class, 'print'])->name('rental-transactions.print');
    Route::resource('rental-transactions', RentalTransactionController::class);
});

require __DIR__.'/auth.php';
