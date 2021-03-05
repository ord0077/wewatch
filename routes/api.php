<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

use App\Http\Controllers\AllocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CovidController;
use App\Http\Controllers\TrainingInductionController;
use App\Http\Controllers\DailySecurityReportController;
use App\Http\Controllers\DailyVisitorsRegisterController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\AccidentIncidentController;


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




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/test', TestController::class);

Route::resource('/allocation', AllocationController::class);


Route::resource('/role', RoleController::class);
Route::resource('/covid', CovidController::class);
Route::resource('/traininginduction', TrainingInductionController::class);
Route::apiResource('/dailysecurityreport', DailySecurityReportController::class);
Route::apiResource('/dailyvisitorsregister', DailyVisitorsRegisterController::class);
Route::apiResource('/observation', ObservationController::class);
Route::apiResource('/accidentincident', AccidentIncidentController::class);


Route::resource('/user', UserController::class);

Route::get('/get_users_by_id/{role_id}', [UserController::class,'get_users_by_id']);
Route::get('/test_by_id/{role_id}', [UserController::class,'test']);

Route::post('change_password/{id}', [UserController::class, 'change_password']);
Route::resource('/project', ProjectController::class);
Route::post('/update_project_logo/{id}', [ProjectController::class, 'update_project_logo']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/master/login', [AuthController::class, 'master_login']);
Route::get('/me', [AuthController::class, 'me']);