<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditlogsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionOfficerController;
use App\Http\Controllers\HomeCOntroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeCOntroller::class, 'index'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Routes
Route::prefix('user')->middleware(['auth'])->controller(UserController::class)->group(function () {
    Route::get('/', 'edit')->name('user.edit');
    Route::post('/update', 'update')->name('user.update');
    Route::delete('/delete', 'delete')->name('user.delete');
    Route::get('/enrollment', 'enrollment')->name('user.enrollment');
    Route::post('/user-enrollment', 'userEnrollment')->name('user.enrollment.post');
});

//Voter Routes
Route::prefix('voter')->middleware(['auth'])->controller(VoterController::class)->group(function () {
    Route::get('/', 'index')->name('voter.index');
    Route::get('/election/{election}', 'election')->name('voting.voter.election');
    Route::post('/vote', 'vote')->name('voting.voter.vote');
    Route::get('/otp-verify/{id}', 'otpVerify')->name('voting.otp.verify');
    Route::post('/otp-verify', 'otpVerifyPost')->name('voting.otp.verify.post');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('admin.index');
    Route::get('/users', 'users')->name('admin.users');
    Route::get('/all-voters', 'allVoters')->name('admin.all.voters');
    Route::get('/voter-delete/{id}', 'voterDelete')->name('admin.voter.delete');
    Route::get('/enrollment', 'enrollment')->name('admin.enrollment');
    Route::get('/all-enrollment', 'allEnrollment')->name('admin.all.enrollment');
    Route::get('voter-status/{id}/{status}', 'voterStatus')->name('admin.voter.status');
});
// Election Officer Routes
Route::prefix('election-officer')->middleware(['auth'])->controller(ElectionOfficerController::class)->group(function () {
    Route::get('/', 'index')->name('election.officer.index');
    Route::get('/get-voters', 'getVoters')->name('election.officer.get.voters');
    Route::get('/get-candidates', 'getCandidates')->name('election.officer.get.candidates');
    Route::post('/save-election', 'saveElection')->name('election.officer.save.election');
});
// Election Routes
Route::prefix('election')->middleware(['auth'])->controller(ElectionController::class)->group(function () {
    Route::get('/ongoing-election', 'ongoingElection')->name('election.ongoing.election');
    Route::get('/get-ongoing-election', 'getOngoingElection')->name('election.get.ongoing.election');
    Route::get('/completed-election', 'completedElection')->name('election.completed.election');
    Route::get('/get-completed-election', 'getCompletedElection')->name('election.get.completed.election');
    Route::get('/get-election-result/{id}', 'getElectionResult')->name('election.get.election.result');
});
// Audit Logs
Route::prefix('audit-log')->middleware(['auth'])->controller(AuditlogsController::class)->group(function () {
    Route::get('/', 'index')->name('auditlog.index');
    Route::get('/get-logs', 'getLogs')->name('auditlog.get');
    Route::get('/download-logs', 'downloadLogs')->name('auditlog.download');
});

Route::prefix('department')->controller(DepartmentController::class)->group(function () {

    Route::get('/all-department', 'allDepartment')->name('department.all.department');
});

require __DIR__ . '/auth.php';
