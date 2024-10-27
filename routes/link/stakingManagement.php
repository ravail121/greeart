<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\StakingDashboardController;
use App\Http\Controllers\admin\StakingOfferController;

// Staking
Route::group(['group' => 'staking', 'prefix' => 'staking'], function () {
    Route::get('dashboard', [StakingDashboardController::class, 'dashboard'])->name('stakingDashboard');
    
    Route::get('offer-create', [StakingOfferController::class, 'createOffer'])->name('stakingCreateOffer');
    Route::get('offer-list', [StakingOfferController::class, 'offerList'])->name('stakingOfferList');
    Route::post('offer-store', [StakingOfferController::class, 'storeOffer'])->name('stakingStoreOffer');
    Route::post('offer-status', [StakingOfferController::class, 'offerStatus'])->name('stakingOfferStatus');
    Route::get('offer-edit-{uid}', [StakingOfferController::class, 'editOffer'])->name('stakingOfferEdit');
    Route::get('delete-offer-{uid}', [StakingOfferController::class, 'deleteOffer'])->name('stakingDeleteOffer');

    Route::get('investment-list', [StakingOfferController::class, 'investmentList'])->name('stakingInvestmentList');
    Route::get('investment-details-{uid}', [StakingOfferController::class, 'investmentDetails'])->name('stakingInvestmentDetails');
    Route::get('give-payment', [StakingOfferController::class, 'givePayment'])->name('stakingGivePayment');

    Route::get('payment-history', [StakingOfferController::class, 'stakingInvestmentPaymentList'])->name('stakingInvestmentPaymentList');
    
    Route::get('landing-settings', [StakingOfferController::class, 'landingSettings'])->name('stakingLandingSettings');
    Route::post('landing-settings-update', [StakingOfferController::class, 'landingSettingsUpdate'])->name('stakingLandingSettingsUpdate');
});
