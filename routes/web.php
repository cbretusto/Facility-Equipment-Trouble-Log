<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\FETLController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\ExportDataController;

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
    return view('dashboard');
})->name('dashboard');

Route::get('/user_management', function () {
    return view('user_management');
})->name('user_management');

Route::get('/equipment', function () {
    return view('equipment');
})->name('equipment');

Route::get('/fetls', function () {
    return view('fetls');
})->name('fetls');

Route::get('/export_report', function () {
    return view('export_report');
})->name('export_report');


Route::get('/get_user_log', [UserController::class, 'getUserLog'])->name('get_user_log');
Route::get('/view_users', [UserController::class, 'viewUsers'])->name('view_users');
Route::get('/get_employee_name', [UserController::class, 'getEmployeeName'])->name('get_employee_name');
Route::get('/get_employee_info', [UserController::class, 'getEmployeeInfo'])->name('get_employee_info');
Route::post('/add_edit_user', [UserController::class, 'addEditUser'])->name('add_edit_user');
Route::get('/get_user_info_by_id', [UserController::class, 'getUserInfoById'])->name('get_user_info_by_id');
Route::post('/change_user_stat', [UserController::class, 'changeUserStat'])->name('change_user_stat');
Route::get('/view_approver_list', [UserController::class, 'viewApproverList'])->name('view_approver_list');
Route::get('/get_approver_name', [UserController::class, 'getApproverName'])->name('get_approver_name');
Route::post('/add_edit_approver', [UserController::class, 'addEditApprover'])->name('add_edit_approver');
Route::get('/get_user_approver_info_by_id', [UserController::class, 'getUserApproverInfoById'])->name('get_user_approver_info_by_id');
Route::post('/remove_approver_stat', [UserController::class, 'removeApproverStat'])->name('remove_approver_stat');

Route::get('/view_equipments', [EquipmentController::class, 'viewEquipments'])->name('view_equipments');
Route::post('/add_edit_equipment', [EquipmentController::class, 'addEditEquipment'])->name('add_edit_equipment');
Route::get('/get_equipment_info_by_id', [EquipmentController::class, 'getEquipmentInfoById'])->name('get_equipment_info_by_id');
Route::post('/change_equipment_status', [EquipmentController::class, 'changeEquipmentStatus'])->name('change_equipment_status');

Route::get('/view_equipment_model', [EquipmentModelController::class, 'viewEquipmentModel'])->name('view_equipment_model');
Route::post('/add_equipment_model', [EquipmentModelController::class, 'addEquipmentModel'])->name('add_equipment_model');
Route::post('/edit_equipment_model', [EquipmentModelController::class, 'editEquipmentModel'])->name('edit_equipment_model');
Route::get('/get_equipment_name_info_by_id', [EquipmentModelController::class, 'getEquipmentNameInfoById'])->name('get_equipment_name_info_by_id');
Route::get('/get_equipment_model_info_by_id', [EquipmentModelController::class, 'getEquipmentModelInfoById'])->name('get_equipment_model_info_by_id');
Route::post('/change_equipment_model_status', [EquipmentModelController::class, 'changeEquipmentModelStatus'])->name('change_equipment_model_status');

Route::get('/view_trouble_logs_approval', [FETLController::class, 'viewTroubleLogsApproval'])->name('view_trouble_logs_approval');
Route::get('/get_equipment', [FETLController::class, 'getEquipment'])->name('get_equipment');
Route::get('/get_equipment_model', [FETLController::class, 'getEquipmentModel'])->name('get_equipment_model');
Route::get('/new_control_no', [FETLController::class, 'newControlNo'])->name('new_control_no');
Route::post('/add_edit_FETL', [FETLController::class, 'addEditFETL'])->name('add_edit_FETL');
Route::get('/get_FETL_info_by_id', [FETLController::class, 'getFETLInfoById'])->name('get_FETL_info_by_id');
Route::post('/change_FETL_status', [FETLController::class, 'changeFETLStatus'])->name('change_FETL_status');
Route::post('/change_FETL_approval', [FETLController::class, 'changeFETLApproval'])->name('change_FETL_approval');
Route::post('/add_FETL_done_by', [FETLController::class, 'addFETLDoneBy'])->name('add_edit_FETL');

// EXPORT DATA
Route::get('/export/{equipment}/{equipmentModel}/{from}/{to}', [ExportDataController::class, 'export']);

