<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PositionsController;
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


Route::get('employees', [EmployeesController::class, 'index'])->name('employees.index');

Route::get('employees/list', [EmployeesController::class, 'getEmployees'])->name('employees.list');

Route::get('employees/edit/{id}', [EmployeesController::class, 'Edit'])->name('employees.edit');

Route::post('employees/store', [EmployeesController::class, 'Store'])->name('employees.store');

Route::delete('employees/delete/{id}', [EmployeesController::class, 'Delete'])->name('employees.delete');

Route::get('positions', [PositionsController::class, 'index'])->name('positions.index');

Route::get('positions/list', [PositionsController::class, 'getPositions'])->name('positions.list');

Route::post('employees/autocomplete', [EmployeesController::class, 'Autocomplete'])->name('employees.autocomplete');

Route::post('positions/autocomplete', [PositionsController::class,'Autocomplete'])->name('positions.autocomplete');


// Route::post('/file-upload', 'GeneralController@store']);
