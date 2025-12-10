<?php

use App\Http\Controllers\{
    FeedbackController,
    AdminDashboardController,
    UnitController,
    InovasiController,
    AnalyticsController,
    InputController
};
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================

// Redirect root ke form feedback
Route::get('/', function () {
    return redirect('/feedback/create');
});

// Redirect /dashboard to admin feedbacks (for post-login)
Route::get('/dashboard', function () {
    return redirect()->route('admin.feedbacks');
});

// User Routes (Form Feedback)
Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/success', [FeedbackController::class, 'success'])->name('feedback.success');

// ============================================
// ADMIN ROUTES (Dengan Auth Middleware)
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard - redirect ke feedback responses
    Route::get('/', function () {
        return redirect()->route('admin.feedbacks');
    });
    
    Route::get('/dashboard', function () {
        return redirect()->route('admin.feedbacks');
    })->name('dashboard');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/data', [AnalyticsController::class, 'getData'])->name('analytics.data');
    
    // Feedback Management
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks');
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    Route::get('/feedbacks/export/excel', [FeedbackController::class, 'exportExcel'])->name('feedbacks.export.excel');
    Route::get('/feedbacks/export/pdf', [FeedbackController::class, 'exportPdf'])->name('feedbacks.export.pdf');
    
    // Gabungan Input Unit & Inovasi
    Route::get('input', [InputController::class, 'index'])->name('input');
    Route::post('input/import-unit', [InputController::class, 'importUnit'])->name('input.importUnit');
    Route::post('input/import-inovasi', [InputController::class, 'importInovasi'])->name('input.importInovasi');

    // Unit Management (nonaktifkan index agar tidak bentrok)
    Route::resource('units', UnitController::class)->except(['index']);
    // Inovasi Management (nonaktifkan index agar tidak bentrok)
    Route::resource('inovasis', InovasiController::class)->except(['index']);
});

// ============================================
// AUTH ROUTES (Laravel Breeze)
// ============================================

require __DIR__.'/auth.php';