<?php

use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('hospitals', [HospitalController::class, 'index'])->name('hospitals');
    Route::post('hospitals', [HospitalController::class, 'store'])->name('hospitals_store');
});

require __DIR__.'/settings.php';
