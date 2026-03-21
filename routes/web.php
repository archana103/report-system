<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
include 'Admin/index.php';
Route::view('/{any}', 'welcome')->where('any', '.*');
