<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskAssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\ClientController;

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

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.+');

// Route::get("/hello", function() {
// 	return view("hello");
// });

// Route::get('/', [TaskAssignController::class, 'index'])->name('task_assign.index');
// Route::get('/create', [TaskAssignController::class, 'create'])->name('task_assign.create');
// Route::post('/create', [TaskAssignController::class, 'store'])->middleware('ConvertStringToArray')->name('task_assign.store');
// Route::get('/edit/{workplace_id}', [TaskAssignController::class, 'edit'])->name('task_assign.edit');
// Route::post('/edit/{workplace_id}', [TaskAssignController::class, 'update'])->name('task_assign.update');

// Route::prefix('employee')->group(function() {
//     Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
//     Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
//     Route::post('/create', [EmployeeController::class, 'store'])->name('employee.store');
//     Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('employee.edit');
//     Route::post('/edit/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
// });

// Route::prefix('workplace')->group(function() {
//     Route::get('/', [WorkplaceController::class, 'index'])->name('workplace.index');
//     Route::get('/create', [WorkplaceController::class, 'create'])->name('workplace.create');
//     Route::post('/create', [WorkplaceController::class, 'store'])->name('workplace.store');
//     Route::get('/edit/{workplace}', [WorkplaceController::class, 'edit'])->name('workplace.edit');
//     Route::post('/edit/{workplace}', [WorkplaceController::class, 'update'])->name('workplace.update');
//     Route::post('/destroy/{workplace}', [WorkplaceController::class, 'destroy'])->name('workplace.destroy');
// });

// Route::prefix('client')->group(function() {
//     Route::get('/', [ClientController::class, 'index'])->name('client.index');
//     Route::get('/create', [ClientController::class, 'create'])->name('client.create');
//     Route::post('/create', [ClientController::class, 'store'])->name('client.store');
//     Route::get('/edit/{client}', [ClientController::class, 'edit'])->name('client.edit');
//     Route::post('/edit/{client}', [ClientController::class, 'update'])->name('client.update');
// });