<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinishedServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ToolServiceController;
use App\Http\Controllers\TrackingServiceController;
use App\Http\Controllers\UserController;
use App\Models\FinishedService;
use Illuminate\Support\Facades\Auth;
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
    return view('pages.index');
});

Auth::routes(['verify' => true]);
Route::middleware(['auth:web', 'verified'])->group(function () {
    //grafik
    Route::get('/service-chart', [HomeController::class, 'serviceChart']);
    Route::get('/service-status-chart', [HomeController::class, 'serviceStatusChart']);
    //home managemen
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/akun-user', [App\Http\Controllers\HomeController::class, 'akunUser'])->name('akun-user');
    Route::get('/pengajuan-service', [App\Http\Controllers\HomeController::class, 'pengajuanService'])->name('pengajuan-service');
    Route::get('/riwayat-service', [App\Http\Controllers\HomeController::class, 'riwayatService'])->name('riwayat-service');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //service managemen
    Route::get('/tracking/{id}', [TrackingServiceController::class, 'index'])->name('tracking');
    Route::post('/tracking/store', [TrackingServiceController::class, 'store'])->name('tracking.store');
    Route::get('/tracking/edit/{di}', [TrackingServiceController::class, 'edit'])->name('tracking.edit');
    Route::get('/tracking-datatable', [TrackingServiceController::class, 'getTrackingDataTable']);
    Route::get('/route-tracking/{id}', [TrackingServiceController::class, 'getTrackingById']);
    //service managemen
    Route::get('/service', [ServiceController::class, 'index'])->name('service');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::post('/service/storeTool', [ServiceController::class, 'storeTool'])->name('service.storeTool');
    Route::get('/service/edit/{di}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::get('/service-datatable', [ServiceController::class, 'getServiceDataTable']);
    Route::get('/finished-service-datatable', [FinishedServiceController::class, 'getFinishedServiceDataTable']);
    //schedule managemen
    Route::get('/schedule', [ScheduleServiceController::class, 'index'])->name('schedule');
    Route::post('/schedule/store', [ScheduleServiceController::class, 'store'])->name('schedule.store');
    Route::post('/schedule/store-arrive', [ScheduleServiceController::class, 'storeArrive'])->name('schedule.store-arrive');
    Route::get('/schedule/edit/{di}', [ScheduleServiceController::class, 'edit'])->name('schedule.edit');
    Route::get('/schedule/service/{id}', [ScheduleServiceController::class, 'scheduleService'])->name('schedule.service');
    Route::get('/schedule/check-arrive/{id}', [ScheduleServiceController::class, 'checkArrive'])->name('schedule.check-arrive');
    Route::get('/schedule-datatable', [ScheduleServiceController::class, 'getScheduleDataTable']);
    //report managemen
    Route::get('/report/finished', [ReportController::class, 'reportFinished'])->name('report.finished');
    Route::get('/report/sparepart', [ReportController::class, 'reportSparepart'])->name('report.sparepart');
    //tool service
    Route::get('/tool-service-datatable', [ToolServiceController::class, 'getToolServiceDataTable']);
    //calendar managemen
    Route::get('/calendar', [ScheduleServiceController::class, 'calendar'])->name('calendar.index');
    Route::get('/calendar/events', [ScheduleServiceController::class, 'getEvents'])->name('calendar.events');
    //customers managemen
    // Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    // Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    // Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    // Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    // Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
});
Route::middleware(['auth:web', 'role:Admin', 'verified'])->group(function () {
    //user managemen
    // Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/admin', [UserController::class, 'admin'])->name('users.admin');
    Route::get('/users/customer', [UserController::class, 'customer'])->name('users.customer');
    Route::get('/users/kepala-teknisi', [UserController::class, 'k_teknisi'])->name('users.kepala-teknisi');
    Route::get('/users/teknisi', [UserController::class, 'teknisi'])->name('users.teknisi');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable/{role}', [UserController::class, 'getUsersDataTable']);
});