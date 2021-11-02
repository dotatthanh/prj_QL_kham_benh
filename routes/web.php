<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ConsultingRoomController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MedicalServiceController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\HealthInsuranceCardController;
use App\Http\Controllers\HealthCertificationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ServiceVoucherController;
use App\Http\Controllers\ServiceVoucherDetailController;

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


Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', function () {
	    return view('dashboard');
	})->name('dashboard');
	
	Route::resource('patients', PatientController::class);

	Route::resource('users', UserController::class);
	Route::get('/users/view-change-password/{user}', [UserController::class, 'viewChangePassword'])->name('users.view-change-password');
	Route::post('/users/change-password/{user}', [UserController::class, 'changePassword'])->name('users.change-password');

	Route::resource('roles', RoleController::class);
	Route::resource('permissions', PermissionController::class);
	Route::resource('consulting_rooms', ConsultingRoomController::class);
	Route::resource('types', TypeController::class);
	Route::resource('medical_services', MedicalServiceController::class);
	Route::resource('medicines', MedicineController::class);

	Route::resource('health_insurance_cards', HealthInsuranceCardController::class);
	Route::post('/health_insurance_cards/{id}/get-insurance-card', [HealthInsuranceCardController::class, 'getInsuranceCard'])->name('health_insurance_cards.get-insurance-card');

	Route::resource('health_certifications', HealthCertificationController::class);
	Route::get('/health_certifications/{health_certification}/conclude', [HealthCertificationController::class, 'viewConclude'])->name('health_certifications.conclude');
	Route::put('/health_certifications/{health_certification}', [HealthCertificationController::class, 'conclude'])->name('health_certifications.update-conclude');

	Route::resource('prescriptions', PrescriptionController::class);
	Route::post('/prescriptions/confirm-payment/{prescription}', [PrescriptionController::class, 'confirmPayment'])->name('prescriptions.confirm-payment');

	Route::resource('service_vouchers', ServiceVoucherController::class);

	Route::resource('service_voucher_details', ServiceVoucherDetailController::class);
	Route::get('/service_voucher_details/delete/{service_voucher_detail}', [ServiceVoucherDetailController::class, 'delete'])->name('service_voucher_details.delete');
});

require __DIR__.'/auth.php';
