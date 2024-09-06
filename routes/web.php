<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenaltySettingController;
use App\Http\Controllers\RecordController;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Member routes
Route::prefix('members')->group(function () {
    Route::post('/store', [MemberController::class, 'store'])->name('members.store');
    Route::get('/data', [MemberController::class, 'getData'])->name('members.data');
    Route::get('/{id}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/data/{id}', [MemberController::class, 'membersdata'])->name('membersdata.get');
    Route::put('/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
});

// Record routes
Route::get('/records/{member_id}', [RecordController::class, 'showRecords'])->name('records.show');

// Penalty Setting routes
Route::prefix('penalty')->group(function () {
    Route::post('/store', [PenaltySettingController::class, 'penaltysubmit'])->name('submit.member.data');
    Route::get('/settings', [PenaltySettingController::class, 'getPenaltySettings'])->name('penalty-settings.get');
    Route::get('/showManagementPage/{id}', [PenaltySettingController::class, 'showManagementPage'])->name('management.page');
});
