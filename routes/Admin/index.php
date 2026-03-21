<?php
use App\Http\Controllers\Admin\AdminAuthController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);
