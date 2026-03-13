<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyInfoController;
use App\Http\Controllers\MedicalServiceController;
use App\Http\Controllers\MyHealthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/medical-services', [MedicalServiceController::class, 'index'])->name('medical-services.index');
    Route::post('/medical-services', [MedicalServiceController::class, 'store'])->name('medical-services.store');
    Route::patch('/medical-services/{medicalServiceRequest}/status', [MedicalServiceController::class, 'updateStatus'])->name('medical-services.update-status');
    Route::delete('/medical-services/{medicalServiceRequest}', [MedicalServiceController::class, 'destroy'])->name('medical-services.destroy');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::patch('/booking/{appointment}/reschedule', [BookingController::class, 'reschedule'])->name('booking.reschedule');
    Route::patch('/booking/{appointment}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    Route::get('/my-health', [MyHealthController::class, 'index'])->name('my-health.index');
    Route::post('/my-health', [MyHealthController::class, 'store'])->name('my-health.store');
    Route::patch('/my-health/{healthRecord}/status', [MyHealthController::class, 'updateStatus'])->name('my-health.update-status');
    Route::delete('/my-health/{healthRecord}', [MyHealthController::class, 'destroy'])->name('my-health.destroy');

    Route::get('/emergency-info', [EmergencyInfoController::class, 'index'])->name('emergency-info.index');
    Route::post('/emergency-info/contacts', [EmergencyInfoController::class, 'storeContact'])->name('emergency-info.store-contact');
    Route::patch('/emergency-info/contacts/{emergencyContact}/primary', [EmergencyInfoController::class, 'setPrimary'])->name('emergency-info.set-primary');
    Route::delete('/emergency-info/contacts/{emergencyContact}', [EmergencyInfoController::class, 'destroy'])->name('emergency-info.destroy-contact');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
