<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\GiftCardController;

Route::group(['middleware' => 'gift_card'], function () {
    // Gift Card Dashboard
    Route::get('gift-card-dashboard-list', [GiftCardController::class, 'giftCardDashboard'])->name("giftCardDashboard");

    // Gift Card Category
    Route::get('gift-card-category-list', [GiftCardController::class, 'giftCardCategoryListPage'])->name("giftCardCategoryListPage");
    Route::get('gift-card-category/{uid?}', [GiftCardController::class, 'giftCardCategory'])->name("giftCardCategory");
    Route::get('gift-card-category-delete-{uid}', [GiftCardController::class, 'giftCardCategoryDelete'])->name("giftCardCategoryDelete");
    Route::post('gift-card-category', [GiftCardController::class, 'giftCardCategorySave'])->name("giftCardCategorySave");

    // Gift Card Banner
    Route::get('gift-card-banner-list', [GiftCardController::class, 'giftCardBannerListPage'])->name("giftCardBannerListPage");
    Route::get('gift-card-banner/{uid?}', [GiftCardController::class, 'giftCardBanner'])->name("giftCardBanner");
    Route::get('gift-card-banner-delete-{uid}', [GiftCardController::class, 'giftCardBannerDelete'])->name("giftCardBannerDelete");
    Route::post('gift-card-banner', [GiftCardController::class, 'giftCardBannerSave'])->name("giftCardBannerSave");

    // Gift Card Fronted Page Header
    Route::get('gift-card-header', [GiftCardController::class, 'giftCardHeader'])->name("giftCardHeader");
    Route::post('gift-card-header', [GiftCardController::class, 'giftCardHeaderSave'])->name("giftCardHeaderSave");

    // Gift Card History
    Route::get('gift-card-history', [GiftCardController::class, 'giftCardHistory'])->name("giftCardHistory");

    // Learn more
    Route::get('gift-card-learn-more', [GiftCardController::class, 'learnMoreGiftCard'])->name('learnMoreGiftCard');
    Route::post('gift-card-learn-more', [GiftCardController::class, 'processLearnMoreGiftCard'])->name('proccessLearnMoreGiftCard');
});
