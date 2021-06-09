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


Route::get('employees', [EmployeesController::class, 'index'])->name('employees.index')->middleware('auth');

Route::get('employees/list', [EmployeesController::class, 'getEmployees'])->name('employees.list')->middleware('auth');

Route::get('employees/edit/{id}', [EmployeesController::class, 'Edit'])->name('employees.edit')->middleware('auth');

Route::post('employees/store', [EmployeesController::class, 'Store'])->name('employees.store')->middleware('auth');

Route::delete('employees/delete/{id}', [EmployeesController::class, 'Delete'])->name('employees.delete')->middleware('auth');

Route::get('positions', [PositionsController::class, 'index'])->name('positions.index')->middleware('auth');

Route::get('positions/list', [PositionsController::class, 'getPositions'])->name('positions.list')->middleware('auth');

Route::post('employees/autocomplete', [EmployeesController::class, 'Autocomplete'])->name('employees.autocomplete')->middleware('auth');

Route::post('positions/autocomplete', [PositionsController::class,'Autocomplete'])->name('positions.autocomplete')->middleware('auth');

Route::get('positions/edit/{id}', [PositionsController::class,'Edit'])->name('positions.edit')->middleware('auth');

Route::post('positions/store', [PositionsController::class, 'Store'])->name('positions.store')->middleware('auth');

Route::delete('positions/delete/{id}', [PositionsController::class, 'Delete'])->name('positions.delete')->middleware('auth');

// Route::post('/file-upload', 'GeneralController@store']);

Auth::routes();

Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['register' => false]);
