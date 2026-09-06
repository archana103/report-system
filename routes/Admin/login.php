<?php
use App\Http\Controllers\Admin\AdminAuthController;
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('guest');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');