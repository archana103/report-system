<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-profile', [DashboardController::class, 'updateUsername'])->name('dashboard.update_profile');
    Route::delete('/dashboard/sessions/{id}', [DashboardController::class, 'logoutSession'])->name('dashboard.logout_session');
    Route::delete('/dashboard/sessions', [DashboardController::class, 'logoutOtherSessions'])->name('dashboard.logout_other_sessions');

    // Change password
    Route::get('/change-password', [AdminAuthController::class, 'showChangePasswordForm'])->name('change_password.form');
    Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('change_password');
});
