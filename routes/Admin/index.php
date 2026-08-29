<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ReportCategoryController;
use App\Http\Controllers\Admin\ReportListController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ReportMethodologyController;
use App\Http\Controllers\Admin\PageSeoController;



// Dashboard & Profile
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/dashboard/update-profile', [DashboardController::class, 'updateUsername'])->name('admin.dashboard.update_profile');
Route::delete('/admin/dashboard/sessions/{id}', [DashboardController::class, 'logoutSession'])->name('admin.dashboard.logout_session');
Route::delete('/admin/dashboard/sessions', [DashboardController::class, 'logoutOtherSessions'])->name('admin.dashboard.logout_other_sessions');

// Global Pricing
Route::get('/admin/pricings', [PricingController::class, 'index']);
Route::post('/admin/pricings', [PricingController::class, 'store']);
Route::put('/admin/pricings/{id}', [PricingController::class, 'update']);
Route::delete('/admin/pricings/{id}', [PricingController::class, 'destroy']);

// Report Methodology
Route::get('/admin/report-methodology-data', [ReportMethodologyController::class, 'index']);
Route::post('/admin/report-methodology-data', [ReportMethodologyController::class, 'store']);

// Category / Report
Route::get('/admin/category-report', [ReportCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/category-report/create', [ReportCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/category-report', [ReportCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/category-report/{id}/edit', [ReportCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/category-report/{id}', [ReportCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/category-report/{id}', [ReportCategoryController::class, 'destroy'])->name('admin.categories.destroy');
Route::get('/admin/category-list', [ReportListController::class, 'index'])->name('admin.reports.index');
Route::get('/admin/category-list/create', [ReportListController::class, 'create'])->name('admin.reports.create');
Route::post('/admin/category-list', [ReportListController::class, 'store'])->name('admin.reports.store');
Route::get('/admin/category-list/{id}/edit', [ReportListController::class, 'edit'])->name('admin.reports.edit');
Route::put('/admin/category-list/{id}', [ReportListController::class, 'update'])->name('admin.reports.update');
Route::delete('/admin/category-list/{id}', [ReportListController::class, 'destroy'])->name('admin.reports.destroy');

// Report Details
Route::get('/admin/category-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'index'])->name('admin.report_details.index');
Route::get('/admin/category-details/create', [App\Http\Controllers\Admin\ReportDetailController::class, 'create'])->name('admin.report_details.create');
Route::post('/admin/category-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'store'])->name('admin.report_details.store');
Route::get('/admin/category-details/{id}/edit', [App\Http\Controllers\Admin\ReportDetailController::class, 'edit'])->name('admin.report_details.edit');
Route::put('/admin/category-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'update'])->name('admin.report_details.update');
Route::delete('/admin/category-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'destroy'])->name('admin.report_details.destroy');
Route::post('/admin/category-details/upload-image', [App\Http\Controllers\Admin\ReportDetailController::class, 'uploadEditorImage'])->name('admin.report_details.upload_image');
Route::post('/admin/editor/upload-image', [App\Http\Controllers\Admin\ReportDetailController::class, 'uploadEditorImage']);
// Top Selling Reports
Route::get('/admin/top-selling-reports', [App\Http\Controllers\Admin\TopSellingReportController::class, 'index'])->name('admin.top_selling_reports.index');
Route::post('/admin/top-selling-reports', [App\Http\Controllers\Admin\TopSellingReportController::class, 'store'])->name('admin.top_selling_reports.store');
Route::delete('/admin/top-selling-reports/{id}', [App\Http\Controllers\Admin\TopSellingReportController::class, 'destroy'])->name('admin.top_selling_reports.destroy');
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

// Pricing Setup
Route::get('/admin/pricing-setup', [App\Http\Controllers\Admin\PricingController::class, 'index'])->name('admin.pricing.index');
Route::post('/admin/pricing-setup', [App\Http\Controllers\Admin\PricingController::class, 'store'])->name('admin.pricing.store');
Route::put('/admin/pricing-setup/{id}', [App\Http\Controllers\Admin\PricingController::class, 'update'])->name('admin.pricing.update');
Route::delete('/admin/pricing-setup/{id}', [App\Http\Controllers\Admin\PricingController::class, 'destroy'])->name('admin.pricing.destroy');

// Report Methodology
Route::get('/admin/report-methodology', [App\Http\Controllers\Admin\ReportMethodologyController::class, 'index'])->name('admin.methodology.index');
Route::post('/admin/report-methodology', [App\Http\Controllers\Admin\ReportMethodologyController::class, 'store'])->name('admin.methodology.store');
