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
Route::get('/admin/blogs', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blogs.index');
Route::get('/admin/blogs/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/admin/blogs', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blogs.store');
Route::get('/admin/blogs/{id}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blogs.edit');
Route::put('/admin/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blogs.update');
Route::delete('/admin/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blogs.destroy');

// Blog Details
Route::get('/admin/blog-details', [App\Http\Controllers\Admin\BlogDetailController::class, 'index'])->name('admin.blog_details.index');
Route::get('/admin/blog-details/{id}/edit', [App\Http\Controllers\Admin\BlogDetailController::class, 'edit'])->name('admin.blog_details.edit');
Route::put('/admin/blog-details/{id}', [App\Http\Controllers\Admin\BlogDetailController::class, 'update'])->name('admin.blog_details.update');
Route::delete('/admin/blog-details/{id}', [App\Http\Controllers\Admin\BlogDetailController::class, 'destroy'])->name('admin.blog_details.destroy');

// Contact Us
Route::get('/admin/contact-us', [App\Http\Controllers\Admin\ContactUsController::class, 'index'])->name('admin.contact_us.index');

// Newsletters
Route::get('/admin/newsletters', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('admin.newsletters.index');
Route::delete('/admin/newsletters/{id}', [App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');

// Request Forms
Route::get('/admin/request-form', [App\Http\Controllers\Admin\RequestFormController::class, 'index'])->name('admin.request_forms.index');
Route::delete('/admin/request-form/{id}', [App\Http\Controllers\Admin\RequestFormController::class, 'destroy'])->name('admin.request_forms.destroy');

// Blog Requests
Route::get('/admin/blog-requests', [App\Http\Controllers\Admin\BlogRequestController::class, 'index'])->name('admin.blog_requests.index');
Route::delete('/admin/blog-requests/{id}', [App\Http\Controllers\Admin\BlogRequestController::class, 'destroy'])->name('admin.blog_requests.destroy');

// Press Release
Route::get('/admin/press-release', [App\Http\Controllers\Admin\PressReleaseController::class, 'index'])->name('admin.press_releases.index');
Route::get('/admin/press-release/create', [App\Http\Controllers\Admin\PressReleaseController::class, 'create'])->name('admin.press_releases.create');
Route::post('/admin/press-release', [App\Http\Controllers\Admin\PressReleaseController::class, 'store'])->name('admin.press_releases.store');
Route::get('/admin/press-release/{id}/edit', [App\Http\Controllers\Admin\PressReleaseController::class, 'edit'])->name('admin.press_releases.edit');
Route::put('/admin/press-release/{id}', [App\Http\Controllers\Admin\PressReleaseController::class, 'update'])->name('admin.press_releases.update');
Route::delete('/admin/press-release/{id}', [App\Http\Controllers\Admin\PressReleaseController::class, 'destroy'])->name('admin.press_releases.destroy');

// Press Release Details
Route::get('/admin/press-release-details', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'index'])->name('admin.press_release_details.index');
Route::get('/admin/press-release-details/{id}/edit', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'edit'])->name('admin.press_release_details.edit');
Route::put('/admin/press-release-details/{id}', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'update'])->name('admin.press_release_details.update');
Route::delete('/admin/press-release-details/{id}', [App\Http\Controllers\Admin\PressReleaseDetailController::class, 'destroy'])->name('admin.press_release_details.destroy');

// Change password
Route::post('/admin/change-password', [AdminAuthController::class, 'changePassword']);

// Page SEO
Route::get('/admin/page-seo', [PageSeoController::class, 'index'])->name('admin.page_seo.index');
Route::post('/admin/page-seo', [PageSeoController::class, 'store'])->name('admin.page_seo.store');
Route::put('/admin/page-seo/{id}', [PageSeoController::class, 'update'])->name('admin.page_seo.update');
Route::delete('/admin/page-seo/{id}', [PageSeoController::class, 'destroy'])->name('admin.page_seo.destroy');

// Purchases
Route::get('/admin/purchases', [\App\Http\Controllers\Admin\PurchaseController::class, 'index'])->name('admin.purchases.index');
Route::delete('/admin/purchases/{id}', [\App\Http\Controllers\Admin\PurchaseController::class, 'destroy'])->name('admin.purchases.destroy');

// Pricing Setup
Route::get('/admin/pricing-setup', [App\Http\Controllers\Admin\PricingController::class, 'index'])->name('admin.pricing.index');
Route::post('/admin/pricing-setup', [App\Http\Controllers\Admin\PricingController::class, 'store'])->name('admin.pricing.store');
Route::put('/admin/pricing-setup/{id}', [App\Http\Controllers\Admin\PricingController::class, 'update'])->name('admin.pricing.update');
Route::delete('/admin/pricing-setup/{id}', [App\Http\Controllers\Admin\PricingController::class, 'destroy'])->name('admin.pricing.destroy');

// Report Methodology
Route::get('/admin/report-methodology', [App\Http\Controllers\Admin\ReportMethodologyController::class, 'index'])->name('admin.methodology.index');
Route::post('/admin/report-methodology', [App\Http\Controllers\Admin\ReportMethodologyController::class, 'store'])->name('admin.methodology.store');
