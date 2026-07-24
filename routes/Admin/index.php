<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ReportCategoryController;
use App\Http\Controllers\Admin\ReportListController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ReportMethodologyController;
use App\Http\Controllers\Admin\PageSeoController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Dashboard & Profile
Route::get('/admin/dashboard-stats', [DashboardController::class, 'stats']);
Route::post('/admin/update-username', [DashboardController::class, 'updateUsername']);

// Sessions Management
Route::get('/admin/sessions', [DashboardController::class, 'getSessions']);
Route::delete('/admin/sessions/{id}', [DashboardController::class, 'logoutSession']);
Route::delete('/admin/sessions', [DashboardController::class, 'logoutOtherSessions']);

// Global Pricing
Route::get('/admin/pricings', [PricingController::class, 'index']);
Route::post('/admin/pricings', [PricingController::class, 'store']);
Route::put('/admin/pricings/{id}', [PricingController::class, 'update']);
Route::delete('/admin/pricings/{id}', [PricingController::class, 'destroy']);

// Report Methodology
Route::get('/admin/report-methodology-data', [ReportMethodologyController::class, 'index']);
Route::post('/admin/report-methodology-data', [ReportMethodologyController::class, 'store']);

// Report Categories
Route::get('/admin/report-categories', [ReportCategoryController::class, 'index']);
Route::post('/admin/report-categories', [ReportCategoryController::class, 'store']);
Route::put('/admin/report-categories/{id}', [ReportCategoryController::class, 'update']);
Route::delete('/admin/report-categories/{id}', [ReportCategoryController::class, 'destroy']);

// Report Lists
Route::get('/admin/report-categories-dropdown', [ReportListController::class, 'categories']);
Route::get('/admin/report-lists-dropdown', [ReportListController::class, 'dropdown']);
Route::get('/admin/report-lists', [ReportListController::class, 'index']);
Route::post('/admin/report-lists', [ReportListController::class, 'store']);
Route::put('/admin/report-lists/{id}', [ReportListController::class, 'update']);
Route::delete('/admin/report-lists/{id}', [ReportListController::class, 'destroy']);

// Report Details
Route::get('/admin/report-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'index']);
Route::post('/admin/report-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'store']);
Route::put('/admin/report-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'update']);
Route::delete('/admin/report-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'destroy']);
Route::post('/admin/editor/upload-image', [App\Http\Controllers\Admin\ReportDetailController::class, 'uploadEditorImage']);
// Top Selling Reports
Route::get('/admin/top-selling-reports-data/search', [App\Http\Controllers\Admin\TopSellingReportController::class, 'search']);
Route::get('/admin/top-selling-reports-data', [App\Http\Controllers\Admin\TopSellingReportController::class, 'index']);
Route::post('/admin/top-selling-reports-data', [App\Http\Controllers\Admin\TopSellingReportController::class, 'store']);
Route::delete('/admin/top-selling-reports-data/{id}', [App\Http\Controllers\Admin\TopSellingReportController::class, 'destroy']);
// Blogs
Route::get('/admin/blogs-data', [App\Http\Controllers\Admin\BlogController::class, 'index']);
Route::post('/admin/blogs-data', [App\Http\Controllers\Admin\BlogController::class, 'store']);
Route::put('/admin/blogs-data/{id}', [App\Http\Controllers\Admin\BlogController::class, 'update']);
Route::delete('/admin/blogs-data/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy']);

// Blog Details
Route::get('/admin/blog-details/blogs-list', [App\Http\Controllers\Admin\BlogDetailController::class, 'getBlogsList']);
Route::get('/admin/blog-details-data', [App\Http\Controllers\Admin\BlogDetailController::class, 'index']);
Route::post('/admin/blog-details-data', [App\Http\Controllers\Admin\BlogDetailController::class, 'store']);
Route::put('/admin/blog-details-data/{id}', [App\Http\Controllers\Admin\BlogDetailController::class, 'update']);
Route::delete('/admin/blog-details-data/{id}', [App\Http\Controllers\Admin\BlogDetailController::class, 'destroy']);

// Contact Us
Route::get('/admin/contact-us-data', [App\Http\Controllers\Admin\ContactUsController::class, 'index']);

// Newsletters
Route::get('/admin/newsletters-data', [App\Http\Controllers\Admin\NewsletterController::class, 'index']);
Route::delete('/admin/newsletters-data/{id}', [App\Http\Controllers\Admin\NewsletterController::class, 'destroy']);

// Request Forms
Route::get('/admin/request-forms', [App\Http\Controllers\Admin\RequestFormController::class, 'index']);
Route::delete('/admin/request-forms/{id}', [App\Http\Controllers\Admin\RequestFormController::class, 'destroy']);

// Blog Requests
Route::get('/admin/blog-requests-data', [App\Http\Controllers\Admin\BlogRequestController::class, 'index']);
Route::delete('/admin/blog-requests-data/{id}', [App\Http\Controllers\Admin\BlogRequestController::class, 'destroy']);

// Press Release
Route::get('/admin/press-releases', [App\Http\Controllers\Admin\PressReleaseController::class, 'index']);
Route::post('/admin/press-releases', [App\Http\Controllers\Admin\PressReleaseController::class, 'store']);
Route::post('/admin/press-releases/{id}', [App\Http\Controllers\Admin\PressReleaseController::class, 'update']); // using POST to handle form data with file uploads
Route::delete('/admin/press-releases/{id}', [App\Http\Controllers\Admin\PressReleaseController::class, 'destroy']);

// Press Release Details
Route::get('/admin/press-release-details-data', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'index']);
Route::post('/admin/press-release-details-data', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'store']);
Route::put('/admin/press-release-details-data/{id}', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'update']);
Route::delete('/admin/press-release-details-data/{id}', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'destroy']);
Route::get('/admin/press-releases-dropdown', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'getPressReleasesList']);

// Change password
Route::post('/admin/change-password', [AdminAuthController::class, 'changePassword']);

// Page SEO
Route::get('/admin/page-seos-data', [PageSeoController::class, 'index']);
Route::post('/admin/page-seos-data', [PageSeoController::class, 'store']);
Route::put('/admin/page-seos-data/{id}', [PageSeoController::class, 'update']);
Route::delete('/admin/page-seos-data/{id}', [PageSeoController::class, 'destroy']);

// Purchases
Route::get('/admin/purchases-data', [\App\Http\Controllers\Admin\PurchaseController::class, 'index']);
Route::delete('/admin/purchases-data/{id}', [\App\Http\Controllers\Admin\PurchaseController::class, 'destroy']);
