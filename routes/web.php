<?php

use App\Http\Controllers\Admin\User\LoginController;
use App\Http\Controllers\Admin\User\DashboardController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',function(){
    return view('home');
});

Route::get('dashboard/index',[DashboardController::class, 'index'])->name('dashboard.index');

Route::get('admin/users/login',[LoginController::class, 'index'])->name('admin.users.login');
Route::post('admin/users/login/store',[LoginController::class, 'store']);
