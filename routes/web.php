<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ConsultingRoomController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MedicalServiceController;

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
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::resource('patients', PatientController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('consulting_rooms', ConsultingRoomController::class);
Route::resource('types', TypeController::class);
Route::resource('medical_services', MedicalServiceController::class);

require __DIR__.'/auth.php';
