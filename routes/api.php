<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\WalletNotifier;
use App\Http\Controllers\Api\Public\PublicController;
use App\Http\Controllers\Api\User\ExchangeController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\KycController;
use App\Http\Controllers\Api\User\DepositController;
use App\Http\Controllers\Api\User\FiatWithdrawalController;
use App\Http\Controllers\Api\User\WalletController;
use App\Http\Controllers\Api\User\StakingOfferController;
use App\Http\Controllers\Api\User\GiftCardController;
use App\Http\Controllers\Api\User\FutureTradeController;
use App\Http\Controllers\Api\User\TransactionDepositController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/coin-payment-notifier', [WalletNotifier::class, 'coinPaymentNotifier'])->name('coinPaymentNotifier');
Route::post('bitgo-wallet-webhook', [WalletNotifier::class, 'bitgoWalletWebhook'])->name('bitgoWalletWebhook');

Route::group(['namespace' => 'Api', 'middleware' => 'wallet_notify'], function () {
    Route::post('wallet-notifier', [WalletNotifier::class, 'walletNotify']);
    Route::post('wallet-notifier-confirm', [WalletNotifier::class, 'notifyConfirm']);
});

// For Two factor
Route::group(['namespace' => 'Api', 'middleware' => ['api-user', 'checkApi']], function () {
    Route::get('two-factor-list', [AuthController::class, 'twoFactorList'])->name("twoFactorListApi");
    Route::match(['GET', 'POST'], '/google-two-factor', [AuthController::class, 'twoFactorGoogleSetup'])->name("twoFactorGoogleApi");
    Route::post('save-two-factor', [AuthController::class, 'twoFactorSave'])->name("twoFactorSaveApi");
    Route::post('send-two-factor', [AuthController::class, 'twoFactorSend'])->name("twoFactorSendApi");
    Route::post('check-two-factor', [AuthController::class, 'twoFactorCheck'])->name("twoFactorCheckApi");
});

Route::group(['middleware' => 'maintenanceMode'], function () {
    Route::group(['namespace' => 'Api\Public', 'prefix' => 'v1/markets', 'middleware' => 'publicSecret'], function () {
        Route::get('price/{pair?}', [PublicController::class, 'getExchangePrice'])->name('getExchangePrice');
        Route::get('orderbook/{pair}', [PublicController::class, 'getExchangeOrderBook'])->name('getExchangeOrderBook');
        Route::get('trade/{pair}', [PublicController::class, 'getExchangeTrade'])->name('getExchangeTrade');
        Route::get('chart/{pair}', [PublicController::class, 'getExchangeChart'])->name('getExchangeChart');
    });

    Route::group(['middleware' => ['checkApi']], function () {
        Route::group(['namespace' => 'Api'], function () {
            // Auth routes
            Route::get('common-settings', [LandingController::class, 'commonSettings']);
            Route::post('sign-up', [AuthController::class, 'signUp']);
            Route::post('sign-in', [AuthController::class, 'signIn']);
            Route::post('verify-email', [AuthController::class, 'verifyEmail']);
            Route::post('resend-verify-email-code', [AuthController::class, 'resendVerifyEmailCode']);
            Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('g2f-verify', [AuthController::class, 'g2fVerify']);
            Route::get('landing', [LandingController::class, 'index']);
            Route::get('banner-list/{id?}', [LandingController::class, 'bannerList']);
            Route::get('announcement-list/{id?}', [LandingController::class, 'announcementList']);
            Route::get('feature-list/{id?}', [LandingController::class, 'featureList']);
            Route::get('social-media-list/{id?}', [LandingController::class, 'socialMediaList']);
            Route::get('captcha-settings', [LandingController::class, 'captchaSettings']);
            Route::get('custom-pages/{type?}', [LandingController::class, 'getCustomPageList']);
            Route::get('pages-details/{slug}', [LandingController::class, 'getCustomPageDetails']);
            Route::get('common-landing-custom-settings', [LandingController::class, 'common_landing_custom_settings']);
            Route::get('faq-list', [FaqController::class, 'faqList']);
            Route::get('market-overview-coin-statistic-list', [LandingController::class, 'getMarketOverviewCoinStatisticList']);
            Route::get('market-overview-top-coin-list', [LandingController::class, 'getMarketOverviewTopCoinList']);
            Route::get('currency-list', [LandingController::class, 'currencyList']);
            Route::get('public-site-settings', [LandingController::class, 'publicSiteSettings']);
        });
        
        Route::group(['namespace' => 'Api\User'], function () {
            Route::get('get-exchange-all-orders-app', [ExchangeController::class, 'getExchangeAllOrdersApp'])->name('getExchangeAllOrdersApp');
            Route::get('app-get-pair', [ExchangeController::class, 'appExchangeGetAllPair'])->name('appExchangeGetAllPair');
            Route::get('app-dashboard/{pair?}', [ExchangeController::class, 'appExchangeDashboard'])->name('appExchangeDashboard');
            Route::get('get-exchange-market-trades-app', [ExchangeController::class, 'getExchangeMarketTradesApp'])->name('getExchangeMarketTradesApp');
            Route::get('get-exchange-chart-data-app', [ExchangeController::class, 'getExchangeChartDataApp'])->name('getExchangeChartDataApp');

            // Staking
            Route::group(['prefix' => 'staking', 'middleware' => 'staking'], function () {
                Route::get('offer-list', [StakingOfferController::class, 'offerList']);
                Route::get('offer-list-details', [StakingOfferController::class, 'offerDetails']);
                Route::get('landing-details', [StakingOfferController::class, 'landingDetails']);
            });
        });

        Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']], function () {
            // Logout
            Route::post('log-out-app', [AuthController::class, 'logOutApp'])->name('logOutApp');
        });

        Route::group(['namespace' => 'Api\User', 'middleware' => ['auth:api', 'api-user', 'generateSecret', 'last_seen']], function () {
            // Profile
            Route::get('notifications', [ProfileController::class, 'userNotification']);
            Route::post('notification-seen', [ProfileController::class, 'userNotificationSeen']);
            Route::get('activity-list', [ProfileController::class, 'activityList']);
            Route::post('update-profile', [ProfileController::class, 'updateProfile']);
            Route::post('change-password', [ProfileController::class, 'changePassword']);
            Route::post('generate-secret-key', [ProfileController::class, 'generateSecretKey']);
            Route::post('show-secret-key', [ProfileController::class, 'showSecretKey']);

            // KYC
            Route::post('send-phone-verification-sms', [ProfileController::class, 'sendPhoneVerificationSms']);
            Route::post('phone-verify', [ProfileController::class, 'phoneVerifyProcess']);
            Route::post('upload-nid', [ProfileController::class, 'uploadNid']);
            Route::post('upload-passport', [ProfileController::class, 'uploadPassport']);
            Route::post('upload-driving-licence', [ProfileController::class, 'uploadDrivingLicence']);
            Route::post('upload-voter-card', [ProfileController::class, 'uploadVoterCard']);
            Route::get('kyc-details', [ProfileController::class, 'kycDetails']);
            Route::get('user-setting', [ProfileController::class, 'userSetting']);
            Route::get('language-list', [ProfileController::class, 'languageList']);
            Route::post('language-setup', [ProfileController::class, 'languageSetup']);
            Route::post('update-currency', [ProfileController::class, 'updateFiatCurrency']);
            Route::get('kyc-active-list', [KycController::class, 'kycActiveList']);
            Route::get('user-kyc-settings-details', [ProfileController::class, 'userKycSettingsDetails'])->name('userKycSettingsDetails');
            Route::post('third-party-kyc-verified', [ProfileController::class, 'thirdPartyKycVerified'])->name('thirdPartyKycVerified');

            Route::group(['middleware' => 'check_demo'], function () {
                Route::post('google2fa-setup', [ProfileController::class, 'google2faSetup']);
                Route::get('setup-google2fa-login', [ProfileController::class, 'setupGoogle2faLogin']);
                Route::post('change-mobile', [ProfileController::class, 'changeMobile']);
            });

            // Deposit
            Route::group(['namespace' => 'Deposit'], function () {
                Route::get('deposit-history', [DepositController::class, 'depositHistory']);
                Route::get('deposit-status/{id}', [DepositController::class, 'depositStatus']);
                Route::post('deposit-store', [DepositController::class, 'store']);
                Route::post('deposit-cancel', [DepositController::class, 'cancelDeposit']);
            });

            // Withdrawal
            Route::group(['namespace' => 'FiatWithdrawal'], function () {
                Route::post('withdraw-fiat', [FiatWithdrawalController::class, 'withdraw']);
                Route::get('withdraw-history', [FiatWithdrawalController::class, 'withdrawHistory']);
            });

            // Wallet
            Route::group(['namespace' => 'Wallet'], function () {
                Route::get('wallet-list', [WalletController::class, 'walletList']);
                Route::post('add-wallet', [WalletController::class, 'addWallet']);
                Route::post('update-wallet', [WalletController::class, 'updateWallet']);
                Route::post('delete-wallet', [WalletController::class, 'deleteWallet']);
                Route::get('wallet-balance', [WalletController::class, 'walletBalance']);
            });

            // Gift Card
            Route::group(['namespace' => 'GiftCard'], function () {
                Route::get('gift-card-list', [GiftCardController::class, 'list']);
                Route::get('gift-card-details/{id}', [GiftCardController::class, 'details']);
                Route::post('gift-card-purchase', [GiftCardController::class, 'purchase']);
            });

            // Future Trade
            Route::group(['namespace' => 'FutureTrade'], function () {
                Route::get('future-trade-history', [FutureTradeController::class, 'history']);
                Route::post('place-order', [FutureTradeController::class, 'placeOrder']);
                Route::post('cancel-order', [FutureTradeController::class, 'cancelOrder']);
            });

            // Transaction Deposits
            Route::group(['namespace' => 'TransactionDeposit'], function () {
                Route::get('transaction-deposit-history', [TransactionDepositController::class, 'history']);
            });
        });
    });
});
