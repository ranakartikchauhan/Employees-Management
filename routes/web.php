<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDataController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $data = User::get();

    return view('dashboard', compact('data'));
})->middleware(['admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
Route::resource('/employees', EmployeeController::class);

Route::get('employees-data', [EmployeeDataController::class, 'index'])->name('get.table.data');
Route::middleware('admin')->get('employees-list/{id}', [EmployeeDataController::class, 'getData']);
