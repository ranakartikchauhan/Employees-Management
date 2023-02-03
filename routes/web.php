<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

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

require __DIR__ . '/auth.php';


Route::resource('/employee', EmployeController::class);

Route::get('emp/listing', [EmployeController::class, 'getEmployees'])->name('get.table.data');

Route::middleware('admin')->get('employee-list/{id}', [EmployeController::class, 'employeeList']);

