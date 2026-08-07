<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
//user side urls
include 'User/index.php';//index page url for landing page
include 'User/aboutus.php';//about page url for /about-us
include 'User/contactus.php';//contact page url for /contact-us
include 'User/service.php';//service page url for /service
include 'User/privacy.php';//privacy page url for /privacy-policy
include 'User/terms.php';//terms page url for /terms-and-conditions
include 'User/thankyou.php';//thank you page url for /thank-you
include 'User/report.php';//report page url for /report
include 'User/blog.php';//report page url for /blog
include 'User/pressrelease.php';//report page url for /pressrelease
include 'User/industry.php';//industry page url for /industry
include 'Paypal/index.php';




//admin urls
include 'Admin/login.php';//admin page login 

Route::middleware(['auth'])->group(function () {
    include 'Admin/index.php';
});

Route::get('storage/{path}', function ($path) {
    return redirect()->away(Storage::disk('s3')->url($path));
})->where('path', '.*');

Route::get('/admin/{any?}', function () {
    return view('welcome', ['seo' => ['title' => 'Admin Panel | Epignosis Insights']]);
})->where('any', '.*');
