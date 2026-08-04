<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintJobController;
use App\Http\Controllers\PrintStreamController;
use App\Http\Middleware\DesktopUniqueKeyMiddleware;
use App\Http\Controllers\PosApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfflineController;
use App\Http\Controllers\Api\PublicApiController;

// SSE: same token as branch unique_hash (X-TABLETRACK-KEY). EventSource cannot send headers.
Route::get('/print-stream/{token}', [PrintStreamController::class, 'stream']);

// called by Electron / Tauri every X seconds (smart polling fallback) or for REST operations
Route::middleware(DesktopUniqueKeyMiddleware::class)->group(function () {
    Route::get('/test-connection', [PrintJobController::class, 'testConnection']);

    //Multiple job pull
    Route::get('/print-jobs/pull-multiple', [PrintJobController::class, 'pullMultiple']);

    Route::get('/printer-details', [PrintJobController::class, 'printerDetails']);

    // mark a job done/failed
    Route::patch('/print-jobs/{printJob}', [PrintJobController::class, 'update']);

    Route::post('/print-jobs/{printJob}/printed', [PrintStreamController::class, 'markPrinted']);
});


Route::prefix('partner/orders')->group(function () {
    Route::get('/{status?}', [PosApiController::class, 'getOrders']);
});

Route::post('application-integration/partner/auth/validate-domain', [HomeController::class, 'validatePartnerDomain']);
Route::get('/bootstrap', [OfflineController::class, 'bootstrap']);
Route::post('/bootstrap/offline/orders', [OfflineController::class, 'createOrder']);

/*
|--------------------------------------------------------------------------
| Public APIs for Table_qr_web Landing Site Integration
|--------------------------------------------------------------------------
*/
Route::prefix('v1/public')->group(function () {
    Route::get('/features', [PublicApiController::class, 'getFeatures']);
    Route::get('/legals', [PublicApiController::class, 'getLegals']);
    Route::get('/social-settings', [PublicApiController::class, 'getSocialSettings']);
    Route::get('/faqs', [PublicApiController::class, 'getFaqs']);
    Route::get('/packages', [PublicApiController::class, 'getPackages']);
    Route::post('/inquiry', [PublicApiController::class, 'submitInquiry']);
    Route::post('/subscribe', [PublicApiController::class, 'subscribeNewsletter']);
    Route::get('/inquiries', [PublicApiController::class, 'getInquiries']);
    Route::get('/subscribers', [PublicApiController::class, 'getSubscribers']);
    Route::get('/tutorials', [PublicApiController::class, 'getTutorials']);
    Route::get('/tutorials/categories', [PublicApiController::class, 'getTutorialCategories']);
    Route::get('/tutorials/{slug}', [PublicApiController::class, 'getTutorialDetail']);
});

