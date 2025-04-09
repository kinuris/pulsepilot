<?php

use App\Http\Controllers\ApiController;
use App\Livewire\AdminHomepage;
use App\Livewire\CalendarView;
use App\Livewire\ChatView;
use App\Livewire\DoctorAccountView;
use App\Livewire\DoctorHomepage;
use App\Livewire\Login;
use App\Livewire\PatientDataMigrationView;
use App\Livewire\PatientManagementView;
use App\Livewire\PatientView;
use App\Livewire\RegistrationKeyView;
use App\Livewire\SettingsView;
use App\Livewire\Signup;
use Illuminate\Support\Facades\Route;

Route::middleware('role:doctor')->group(function () {
    Route::get('/', DoctorHomepage::class)->name('home');
    Route::get('/patients', PatientView::class)->name('patients');
    Route::get('/manage', PatientManagementView::class)->name('manage');
    Route::get('/chat', ChatView::class)->name('chats');
    Route::get('/calendar', CalendarView::class)->name('calendar');
    Route::get('/settings', SettingsView::class)->name('settings');
});

Route::middleware('role:admin')->group(function () {
    Route::get('/admin', AdminHomepage::class)->name('admin.home');
    Route::get('/admin/registration-keys', RegistrationKeyView::class)->name('admin.registration-keys');
    Route::get('/admin/doctor-accounts', DoctorAccountView::class)->name('admin.doctor-accounts');
    Route::get('/admin/patient-data', PatientDataMigrationView::class)->name('admin.patient-data');
});

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/signup', Signup::class)
    ->middleware('guest')
    ->name('signup');

Route::controller(ApiController::class)->group(function () {
    Route::post('/api/patient/create', 'createPatient');

    Route::post('/api/patient/{patient}/sync', 'syncPatient');

    Route::post('/api/patient/{patient}/glucose', 'syncGlucoseRecords');
    Route::post('/api/patient/{patient}/water', 'syncWaterRecords');
    Route::post('/api/patient/{patient}/medication', 'syncMedicationRecords');
    Route::post('/api/patient/{patient}/bmi', 'syncBmiRecords');
    Route::post('/api/patient/{patient}/nutrition', 'syncNutritionRecords');
    Route::post('/api/patient/{patient}/activity', 'syncActivityRecords');

    Route::post('/api/patient/{patient}/lab', 'getPatientLabRequest');
    Route::post('/api/patient/{patient}/lab/result', 'submitLabResult');

    Route::post('/api/patient/{patient}/history/immunization', 'getImmunizationHistory');
    Route::post('/api/patient/{patient}/history/condition', 'getConditionHistory');

    Route::post('/api/chat/batch/{patient}/{doctor}', 'getChatBatch');
    Route::post('/api/chat/send/{doctor}', 'sendChatMessage');
    Route::post('/api/doctors/{patient}/monitoring', 'getMonitoringDoctors');

    Route::post('/api/online/{patient}/ping', 'pingOnline');
    Route::post('/api/online/{patient}/doctors', 'getOnlineDoctors');

    Route::post('/api/recover/{recoveryId}', 'recoverData');
    Route::post('/api/appointment/{user}/timeslots', 'getTimeSlots');
    Route::post('/api/appointment/{user}/{patient}/create', 'createAppointment');
    Route::post('/api/appointment/{patient}', 'getAppointments');
});
