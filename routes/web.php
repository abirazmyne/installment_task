<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenaltySettingController;
use App\Http\Controllers\RecordController;

// Route for the home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route to store a new member
Route::post('/members/store', [MemberController::class, 'store'])->name('members.store');
Route::get('/records/{member_id}', [RecordController::class, 'showRecords'])->name('records.show');
// routes/web.php
// routes/web.php
Route::post('/penalty/store', [PenaltySettingController::class, 'penaltysubmit'])->name('submit.member.data');
Route::get('/showManagementPage/{id}', [PenaltySettingController::class, 'showManagementPage'])->name('management.page');

Route::get('/members/data', [MemberController::class, 'getData'])->name('members.data');

// Route to get member data (for editing)
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/data/{id}', [MemberController::class, 'membersdata'])->name('membersdata.get');


// Route to update a member
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');

// Route to delete a member
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

// routes/web.php
Route::get('/penalty-settings', [PenaltySettingController::class, 'getPenaltySettings'])->name('penalty-settings.get');
