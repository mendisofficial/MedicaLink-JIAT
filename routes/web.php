<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\PatientProfileController;

Route::get('/', function () {
    return view('landing');
});

Route::get('patient/login', [PatientAuthController::class, 'showLoginForm'])->name('patient.login');
Route::post('patient/login', [PatientAuthController::class, 'login']);
Route::post('patient/logout', [PatientAuthController::class, 'logout'])->name('patient.logout');

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/workingOnIt', function (){
    return view('working_on_it');
})->name('workingOnIt');

// Patient routes
Route::middleware('auth:patient')->group(function () {

    Route::get('/patient/dashboard', [PatientProfileController::class, 'index'])
    ->name('patient.dashboard');

    Route::get('/patient/search', [PatientProfileController::class, 'showSearchPage'])
    ->name('patient.search');

    Route::get('/patient/data/vaccinations', [PatientProfileController::class, 'handleVaccinationData'])->name('patient.vaccineData');

    Route::get('/patient/data/reports', [PatientProfileController::class, 'handleReportData'])->name('patient.reportData');

    Route::get('/patient/data/vaccinations/search', [PatientProfileController::class, 'searchVaccinationData'])->name('patient.searchVaccineData');

    Route::get('/patient/data/reports/search', [PatientProfileController::class, 'searchReportData'])->name('patient.searchReportData');
});

// Admin routes
Route::middleware('auth:admin')->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // All patients search
    Route::get('/admin/patient/search', [AdminController::class, 'searchPatientForm'])
        ->name('admin.searchPatientForm');

    // Individual patient profile
    Route::get('/admin/patient/{id}', [AdminController::class, 'showPatientProfile'])
        ->where('id', '[0-9]+')
        ->name('admin.patientProfile');

    Route::delete('/admin/patients/{id}', [AdminController::class, 'destroyPatient'])
        ->name('admin.deletePatient');

    // Individual patient profile - Vaccinations and Medical Reports
    Route::get('/admin/patient/{id}/reports', [AdminController::class, 'showPatientProfileReports'])
        ->where('id', '[0-9]+')
        ->name('admin.patientProfileReports');

    Route::get('/admin/patient', [AdminController::class, 'showManagePatients'])
        ->name('admin.managePatients');

    Route::get('/admin/patient/add', [AdminController::class, 'showAddPatientForm'])
        ->name('admin.addPatientForm');

    // Patient data Update Insert routes
    Route::post('/admin/patient/vaccinations/update', [AdminController::class, 'updateVaccination'])
    ->name('admin.patient.updateVaccination');

    Route::post('/admin/patient/vaccinations/add', [AdminController::class, 'insertVaccination'])
    ->name('admin.patient.addVaccination');

    Route::post('/admin/patient/reports/add', [AdminController::class, 'insertMedicalRecord'])
    ->name('admin.patient.addReport');

    Route::post('/admin/patient/reports/update', [AdminController::class, 'updateMedicalRecord'])
    ->name('admin.patient.updateReport');

    Route::post('/admin/patient/store', [AdminController::class, 'storePatient'])
    ->name('admin.storePatient');

    Route::post('/admin/store_patient', [AdminController::class, 'storePatient'])
    ->name('admin.storePatient');

    Route::get('/admin/patient/data/vaccine-brands', [AdminController::class, 'getVaccineBrands'])->name('admin.getVaccineBrands');

    Route::get('/admin/patient/data/vaccinations', [AdminController::class, 'handlePatientVaccinationData'])->name('admin.patientVaccineData');

    Route::get('/admin/patient/data/reports', [AdminController::class, 'handlePatienReportData'])->name('admin.patientReportData');

    Route::get('/admin/patient/data/vaccinations/search', [AdminController::class, 'searchPatientVaccinationData'])->name('admin.patientSearchVaccineData');

    Route::get('/admin/patient/data/reports/search', [AdminController::class, 'searchPatienReportData'])->name('admin.patientSearchReportData');
});

require __DIR__.'/auth.php';
