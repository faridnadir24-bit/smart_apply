<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CoverLetterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (redirect by role)
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    $profile = auth()->user()->applicantProfile;
    return view('dashboard', compact('profile'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    Route::get('/admin/pelamar/{id}', [AdminController::class, 'show'])
        ->name('admin.pelamar.show');
});

// Routes USER — middleware auth saja, cek role di controller
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/biodata', [ApplicantProfileController::class, 'index'])
        ->name('applicant.biodata');
    Route::post('/biodata', [ApplicantProfileController::class, 'update'])
        ->name('applicant.biodata.update');
    Route::post('/biodata/upload-cv', [ApplicantProfileController::class, 'uploadCv'])
        ->name('applicant.upload-cv');
});

Route::get('/admin/pelamar', [AdminController::class, 'pelamarIndex'])
    ->name('admin.pelamar.index');

// Routes LOWONGAN & LAMARAN (Mhs 2)
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobListing}', [JobListingController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/jobs/{jobListing}/apply', [JobListingController::class, 'apply'])->name('jobs.apply');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
});

// Routes LOWONGAN & LAMARAN (Mhs 2)
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobListing}', [JobListingController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/jobs/{jobListing}/apply', [JobListingController::class, 'apply'])->name('jobs.apply');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
});

// Routes SURAT LAMARAN AI (Mhs 3)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cover-letters', [CoverLetterController::class, 'index'])->name('cover-letters.index');
    Route::get('/cover-letters/create', [CoverLetterController::class, 'create'])->name('cover-letters.create');
    Route::post('/cover-letters/generate', [CoverLetterController::class, 'generate'])->name('cover-letters.generate');
    Route::get('/cover-letters/{coverLetter}', [CoverLetterController::class, 'show'])->name('cover-letters.show');
    Route::delete('/cover-letters/{coverLetter}', [CoverLetterController::class, 'destroy'])->name('cover-letters.destroy');
    Route::get('/jobs/{jobListing}/generate-surat', [CoverLetterController::class, 'createFromJob'])->name('cover-letters.from-job');
});
require __DIR__.'/auth.php';