<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $data = User::get();
    return view('dashboard', compact('data'));
})->middleware(['admin', 'auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
Route::resource('/employees', EmployeeController::class);
Route::post('employees-data', [EmployeeDataController::class, 'index'])->name('get.table.data');
Route::middleware('admin')->get('employees-list/{id}', [EmployeeDataController::class, 'getData']);
Route::get('change-password', [ChangePasswordController::class, 'changePassword'])->middleware(['auth'])->name('change.password');
Route::post('change-password', [ChangePasswordController::class, 'updatePassword'])->middleware(['auth'])->name('update-password');
