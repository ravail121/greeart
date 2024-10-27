<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LandingController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\AnnouncementController;

Route::group(['group' => 'landing'], function () {
    Route::get('landing-page-setting', [LandingController::class, 'adminLandingSetting'])->name('adminLandingSetting');
    Route::get('landing-page-download-link-{type}', [LandingController::class, 'adminLandingApiLinkUpdateView'])->name('adminLandingApiLinkUpdateView');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::post('landing-api-link-setting-save', [LandingController::class, 'adminLandingApiLinkSave'])->name('adminLandingApiLinkSave');
        Route::post('landing-section-setting-save', [LandingController::class, 'adminLandingSectionSettingsSave'])->name('adminLandingSectionSettingsSave');
        Route::post('landing-pair-asset-setting-save', [LandingController::class, 'adminLandingPairAssetSave'])->name('adminLandingPairAssetSave');
        Route::post('landing-page-setting-save', [LandingController::class, 'adminLandingSettingSave'])->name('adminLandingSettingSave');
    });
});

// landing banner
Route::group(['group' => 'banner'], function () {
    Route::get('landing-banner-list', [BannerController::class, 'adminBannerList'])->name('adminBannerList');
    Route::get('landing-banner-add', [BannerController::class, 'adminBannerAdd'])->name('adminBannerAdd');
    Route::get('landing-banner-edit-{id}', [BannerController::class, 'adminBannerEdit'])->name('adminBannerEdit');
    Route::post('landing-banner-save', [BannerController::class, 'adminBannerSave'])->name('adminBannerSave')->middleware('check_demo');
    Route::get('landing-banner-delete-{id}', [BannerController::class, 'adminBannerDelete'])->name('adminBannerDelete')->middleware('check_demo');
});

// landing announcement
Route::group(['group' => 'announcement'], function () {
    Route::get('landing-announcement-list', [AnnouncementController::class, 'adminAnnouncementList'])->name('adminAnnouncementList');
    Route::get('landing-announcement-add', [AnnouncementController::class, 'adminAnnouncementAdd'])->name('adminAnnouncementAdd');
    Route::get('landing-announcement-edit-{id}', [AnnouncementController::class, 'adminAnnouncementEdit'])->name('adminAnnouncementEdit');
    Route::post('landing-announcement-save', [AnnouncementController::class, 'adminAnnouncementSave'])->name('adminAnnouncementSave')->middleware('check_demo');
    Route::get('landing-announcement-delete-{id}', [AnnouncementController::class, 'adminAnnouncementDelete'])->name('adminAnnouncementDelete')->middleware('check_demo');
});

// landing feature
Route::group(['group' => 'feature'], function () {
    Route::get('landing-feature-list', [LandingController::class, 'adminFeatureList'])->name('adminFeatureList');
    Route::get('landing-feature-add', [LandingController::class, 'adminFeatureAdd'])->name('adminFeatureAdd');
    Route::get('landing-feature-edit-{id}', [LandingController::class, 'adminFeatureEdit'])->name('adminFeatureEdit');
    Route::post('landing-feature-save', [LandingController::class, 'adminFeatureSave'])->name('adminFeatureSave')->middleware('check_demo');
    Route::get('landing-feature-delete-{id}', [LandingController::class, 'adminFeatureDelete'])->name('adminFeatureDelete')->middleware('check_demo');
});

// landing social media
Route::group(['group' => 'media'], function () {
    Route::get('landing-social-media-list', [LandingController::class, 'adminSocialMediaList'])->name('adminSocialMediaList');
    Route::get('landing-social-media-add', [LandingController::class, 'adminSocialMediaAdd'])->name('adminSocialMediaAdd');
    Route::get('landing-social-media-edit-{id}', [LandingController::class, 'adminSocialMediaEdit'])->name('adminSocialMediaEdit');
    Route::post('landing-social-media-save', [LandingController::class, 'adminSocialMediaSave'])->name('adminSocialMediaSave')->middleware('check_demo');
    Route::get('landing-social-media-delete-{id}', [LandingController::class, 'adminSocialMediaDelete'])->name('adminSocialMediaDelete')->middleware('check_demo');
});
