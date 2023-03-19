<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskAssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/task_assign')->group(function() {
    Route::get('/', [TaskAssignController::class, 'index']);
    Route::post('/', [TaskAssignController::class, 'store']);
    Route::get('/fetch_task_assign', [TaskAssignController::class, 'fetchTaskAssign']);
    Route::get('/fetch_clients_with_workplaces', [TaskAssignController::class, 'fetchClientsWithWorkplaces']);
    Route::get('/fetch_employees', [TaskAssignController::class, 'fetchEmployees']);
    Route::get('/fetch_workplace', [TaskAssignController::class, 'fetchWorkplace']);
    Route::post('/update', [TaskAssignController::class, 'update']);
    Route::delete('/delete', [TaskAssignController::class, 'destroy']);
});

Route::prefix('/employee')->group(function() {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('/fetch_employee', [EmployeeController::class, 'fetchEmployee']);
    Route::get('/fetch_contract_types', [EmployeeController::class, 'fetchContractTypes']);
    Route::get('/fetch_prefectures', [EmployeeController::class, 'fetchPrefectures']);
    Route::post('/update', [EmployeeController::class, 'update']);
    Route::delete('/delete', [EmployeeController::class, 'destroy']);
});

Route::prefix('/client')->group(function() {
    Route::get('/', [ClientController::class, 'index']);
    Route::post('/', [ClientController::class, 'store']);
    Route::get('/fetch_client', [ClientController::class, 'fetchClient']);
    Route::get('/fetch_prefectures', [ClientController::class, 'fetchPrefectures']);
    Route::post('/update', [ClientController::class, 'update']);
    Route::delete('/delete', [ClientController::class, 'destroy']);
});

Route::prefix('/workplace')->group(function() {
    Route::get('/', [WorkplaceController::class, 'index']);
    Route::post('/', [WorkplaceController::class, 'store']);
    Route::get('/fetch_workplace', [WorkplaceController::class, 'fetchWorkplace']);
    Route::get('/fetch_clients', [WorkplaceController::class, 'fetchClients']);
    Route::get('/fetch_prefectures', [WorkplaceController::class, 'fetchPrefectures']);
    Route::post('/update', [WorkplaceController::class, 'update']);
    Route::delete('/delete', [WorkplaceController::class, 'destroy']);
});
