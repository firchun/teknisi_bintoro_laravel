<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/akun-user', [App\Http\Controllers\HomeController::class, 'akunUser'])->name('akun-user');
    Route::get('/pengajuan-service', [App\Http\Controllers\HomeController::class, 'pengajuanService'])->name('pengajuan-service');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //service managemen
    Route::get('/service', [ServiceController::class, 'index'])->name('service');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/service-datatable', [ServiceController::class, 'getServiceDataTable']);
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
