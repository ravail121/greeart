<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\Public\PublicController;
use App\Http\Controllers\Api\User\BuyOrderController;
use App\Http\Controllers\Api\User\ExchangeController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\KycController;
use App\Http\Controllers\Api\User\CoinController;
use App\Http\Controllers\Api\User\WalletController;
use App\Http\Controllers\Api\User\DepositController;
use App\Http\Controllers\Api\User\FiatWithdrawalController;
use App\Http\Controllers\Api\User\PaystackPaymentController;
use App\Http\Controllers\Api\User\UserBankController;
use App\Http\Controllers\Api\User\StakingOfferController;
use App\Http\Controllers\Api\User\FutureTradeController;
use App\Http\Controllers\Api\User\FutureTrade\FutureTradeReportController;
use App\Http\Controllers\Api\User\GiftCardController;
use App\Http\Controllers\Api\User\ReportController;
use App\Http\Controllers\Api\User\SellOrderController;
use App\Http\Controllers\Api\User\TransactionDepositController;
use App\Http\Controllers\Api\WalletNotifier;

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


Route::group(['middleware' => 'maintenanceMode'], function (){

    Route::group(['namespace' => 'Api\Public', 'prefix' => 'v1/markets', 'middleware' => 'publicSecret'], function () {
        Route::get('price/{pair?}', [PublicController::class, 'getExchangePrice'])->name('getExchangeTrade');
        Route::get('orderbook/{pair}', [PublicController::class, 'getExchangeOrderBook'])->name('getExchangeOrderBook');
        Route::get('trade/{pair}', [PublicController::class, 'getExchangeTrade'])->name('getExchangeTrade');
        Route::get('chart/{pair}', [PublicController::class, 'getExchangeChart'])->name('getExchangeChart');
    });

    Route::group(['middleware' => ['checkApi']], function () {
        Route::group(['namespace' => 'Api'], function () {
            // auth
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
        
            // staking
            Route::group(['group' => 'staking', 'prefix' => 'staking', 'middleware' => 'staking'], function () {
                Route::get('offer-list', [StakingOfferController::class, 'offerList']);
                Route::get('offer-list-details', [StakingOfferController::class, 'offerDetails']);
                Route::get('landing-details', [StakingOfferController::class, 'landingDetails']);
            });
        });

        Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']], function () {
            //logout
            Route::post('log-out-app', [AuthController::class, 'logOutApp'])->name('logOutApp');
        });


        Route::group(['namespace' => 'Api\User', 'middleware' => ['auth:api', 'api-user', 'generateSecret', 'last_seen']], function () {
            // profile
            Route::get('notifications', [ProfileController::class, 'userNotification']);
            Route::post('notification-seen', [ProfileController::class, 'userNotificationSeen']);
            Route::get('activity-list', [ProfileController::class, 'activityList']);
            Route::post('update-profile', [ProfileController::class, 'updateProfile']);
            Route::post('change-password', [ProfileController::class, 'changePassword']);
            Route::post('generate-secret-key', [ProfileController::class, 'generateSecretKey']);
            Route::post('show-secret-key', [ProfileController::class, 'showSecretKey']);
        
            // kyc
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
                Route::post('profile-delete-request', [ProfileController::class, 'profileDeleteRequest']);
            });
        
            // coin
            Route::get('get-coin-list', [CoinController::class, 'getCoinList']);
            Route::get('get-coin-pair-list', [CoinController::class, 'getCoinPairList']);
        
            Route::group(['middleware' => ['checkSwap']], function () {
                Route::get('swap-coin-details-app', [WalletController::class, 'getCoinSwapDetailsApp'])->name('getCoinSwapDetailsApp');
                Route::get('get-rate-app', [WalletController::class, 'getRateApp'])->name('getRateApp');
                Route::get('coin-swap-app', [WalletController::class, 'coinSwapApp'])->name('coinSwapApp');
                Route::post('swap-coin-app', [WalletController::class, 'swapCoinApp'])->name('swapCoinApp');
                Route::get('coin-convert-history-app', [WalletController::class, 'coinSwapHistoryApp'])->name('coinSwapHistoryApp');
            });
        
            Route::get('referral-app', [ProfileController::class, 'myReferralApp'])->name('myReferralApp');
        
            Route::group(['middleware' => ['checkCurrencyDeposit']], function () {
                Route::get('deposit-bank-details/{id}', [DepositController::class, 'depositBankDetails'])->name('depositBankDetails');
                Route::get('currency-deposit', [DepositController::class, 'currencyDepositInfo'])->name('currencyDepositInfo');
                Route::post('get-currency-deposit-rate', [DepositController::class, 'currencyDepositRate'])->name('currencyDepositRate');
                Route::post('currency-deposit-process', [DepositController::class, 'currencyDepositProcess'])->name('currencyDepositProcess');
                Route::get('currency-deposit-history', [DepositController::class, 'currencyDepositHistory'])->name('currencyDepositHistory');
            });
        
            Route::post('get-convert-currency-amount', [DepositController::class, 'getCurrencyRate']);
        
            // fiat withdrawal
            Route::get('fiat-withdrawal', [FiatWithdrawalController::class, 'fiatWithdrawal'])->name('fiatWithdrawal');
            Route::post('get-fiat-withdrawal-rate', [FiatWithdrawalController::class, 'getFiatWithdrawalRate'])->name('getFiatWithdrawalRate');
            Route::post('fiat-withdrawal-process', [FiatWithdrawalController::class, 'fiatWithdrawalProcess'])->name('fiatWithdrawalProcess');
            Route::get('fiat-withdrawal-history', [FiatWithdrawalController::class, 'fiatWithdrawHistory'])->name('fiatWithdrawHistory');
            Route::post('get-paystack-payment-url', [PaystackPaymentController::class, 'getPaystackPaymentURL']);
            Route::post('verification-paystack-payment', [PaystackPaymentController::class, 'verificationPaystackPayment']);
        
            // User Bank
            Route::get('user-bank-list', [UserBankController::class, 'UserbankGet'])->name("UserbankGet");
            Route::post('user-bank-save', [UserBankController::class, 'UserBankSave'])->name("UserBankSave");
            Route::post('user-bank-delete', [UserBankController::class, 'UserBankDelete'])->name("UserBankDelete");
        
            // staking
            Route::group(['group' => 'staking', 'prefix' => 'staking', 'middleware' => 'staking'], function () {
                Route::post('get-total-investment-bonus', [StakingOfferController::class, 'getTotalInvestmentBonus']);
                Route::post('investment-submit', [StakingOfferController::class, 'submitInvestment']);
                Route::post('investment-canceled', [StakingOfferController::class, 'canceledInvestment']);
                Route::get('investment-list', [StakingOfferController::class, 'investmentList']);
                Route::get('investment-details', [StakingOfferController::class, 'investmentDetails']);
                Route::get('earning-list', [StakingOfferController::class, 'earningList']);
                Route::get('investment-statistics', [StakingOfferController::class, 'investmentStatistics']);
                Route::get('investment-get-payment-list', [StakingOfferController::class, 'investmentGetPaymentList']);
            });
        
            // future trade
            Route::group(['group' => 'future-trade', 'prefix' => 'future-trade', 'middleware' => 'createFutureWallet'], function () {
                Route::get('common-settings', [FutureTradeController::class, 'commonSettings']);
                Route::get('wallet-list', [FutureTradeController::class, 'walletList']);
                Route::post('wallet-balance-transfer', [FutureTradeController::class, 'walletBalanceTransfer']);
                Route::get('transfer-history', [FutureTradeController::class, 'walletTransferHistory']);
                Route::get('coin-pair-list', [FutureTradeController::class, 'coinPairList']);
                Route::post('preplace-order-data', [FutureTradeController::class, 'prePlaceOrderData']);
                Route::post('placed-buy-order', [FutureTradeController::class, 'placedBuyOrder']);
                Route::post('update-profit-loss-long-short-order', [FutureTradeController::class, 'updateProfitLossLongShortOrder']);
                Route::post('placed-sell-order', [FutureTradeController::class, 'placedSellOrder']);
                Route::get('get-long-short-position-order-list', [FutureTradeController::class, 'getLongShortPositionOrderList']);
                Route::get('get-long-short-open-order-list', [FutureTradeController::class, 'getLongShortOpenOrderList']);
                Route::get('get-long-short-order-history', [FutureTradeController::class, 'getLongShortOrderHistory']);
                Route::get('get-long-short-transaction-history', [FutureTradeController::class, 'getLongShortTransactionHistory']);
                Route::get('get-long-short-trade-history', [FutureTradeController::class, 'getLongShortTradeHistory']);
                Route::post('close-long-short-order', [FutureTradeController::class, 'closeLongShortOrder']);
                Route::post('close-long-short-all-orders', [FutureTradeController::class, 'closeLongShortAllOrders']);
                Route::post('get-future-order-calculation', [FutureTradeController::class, 'getFutureTradeOrderCalculation']);
                Route::post('canceled-long-short-order', [FutureTradeController::class, 'canceledLongShortOrder']);
                Route::post('order-details', [FutureTradeController::class, 'orderDetails']);
                Route::get('get-my-all-orders-app', [FutureTradeController::class, 'getFutureTradeOrdersApp']);
                Route::get('get-my-trades-app', [FutureTradeController::class, 'getFutureTradeMyExchangeTradesApp']);
                Route::post('cancel-open-order-app', [FutureTradeController::class, 'deleteFutureTradeMyOrderApp']);
                Route::get('get-tp-sl-details-{uid}', [FutureTradeReportController::class, 'getTpSlDetails']);
                Route::get('test', [FutureTradeController::class, 'test']);
            });
        });
        // Gift Card routes without authentication
        Route::group(['namespace' => 'Api\User', 'group' => 'gift_card', 'prefix' => 'gift-card'], function () {
            Route::get('gift-card-main-page', [GiftCardController::class, 'giftCardMainPageData']);
            Route::get('gift-cards', [GiftCardController::class, 'giftCards']);
        });

        // Gift Card routes with authentication
        Route::group(['namespace' => 'Api\User', 'group' => 'gift_card', 'prefix' => 'gift-card', 'middleware' => ['auth:api', 'api-user', 'last_seen']], function () {
            Route::post('buy-card', [GiftCardController::class, 'buyGiftCard']);
            Route::post('update-card', [GiftCardController::class, 'updateGiftCard']);
            Route::get('buy-card-page-data', [GiftCardController::class, 'buyGiftCardPageData']);
            Route::get('check-card', [GiftCardController::class, 'checkGiftCard']);
            Route::get('redeem-card', [GiftCardController::class, 'redeemGiftCard']);
            Route::get('my-gift-card-list', [GiftCardController::class, 'giftCardList']);
            Route::get('gift-card-wallet-data', [GiftCardController::class, 'buyGiftCardPageWalletData']);
            Route::get('add-gift-card', [GiftCardController::class, 'addGiftCard']);
            Route::get('gift-card-themes-page', [GiftCardController::class, 'allGiftCardThemePageData']);
            Route::get('get-gift-card-themes', [GiftCardController::class, 'getGiftCardTheme']);
            Route::get('send-gift-card', [GiftCardController::class, 'sendGiftCard']);
            Route::get('my-gift-card-page', [GiftCardController::class, 'myGiftCardPageData']);
            Route::get('get-gift-card-learn-more-page', [GiftCardController::class, 'getGiftCardLearnMorePage']);
            Route::post('get-redeem-code', [GiftCardController::class, 'getRedeemCode']);
        });
        Route::group(['namespace' => 'Api\User'], function () {
            Route::group(['group' => 'future-trade', 'prefix' => 'future-trade'], function () {
                Route::get('get-market-pair-data', [FutureTradeController::class, 'getFutureTradeMarketPairData']);
                Route::get('get-all-orders-app', [FutureTradeController::class, 'getFutureAllOrdersApp']);
                Route::get('app-get-pair', [FutureTradeController::class, 'appFutureTradeGetAllPair']);
                Route::get('app-dashboard/{pair?}', [FutureTradeController::class, 'appFutureTradeDashboard']);
                Route::get('get-market-trades-app', [FutureTradeController::class, 'getFutureTradeMarketTradesApp']);
                Route::get('get-chart-data-app', [FutureTradeController::class, 'getFutureTradeChartDataApp']);
                Route::get('get-all-buy-orders-app', [FutureTradeController::class, 'getFutureTradeAllBuyOrdersApp']);
                Route::get('get-all-sell-orders-app', [FutureTradeController::class, 'getFutureTradeAllSellOrdersApp']);
                Route::get('all-buy-orders-history-app', [FutureTradeController::class, 'getFutureTradeAllOrdersHistoryBuyApp']);
                Route::get('all-sell-orders-history-app', [FutureTradeController::class, 'getFutureTradeAllOrdersHistorySellApp']);
                Route::get('all-transaction-history-app', [FutureTradeController::class, 'getFutureTradeAllTransactionHistoryApp']);
                Route::get('get-exchange-all-orders-app', [FutureTradeController::class, 'getFutureTradeExchangeAllOrdersApp']);
                Route::get('get-exchange-market-trades-app', [FutureTradeController::class, 'getFutureTradeExchangeMarketTradesApp']);
                Route::get('get-exchange-market-details-app', [FutureTradeController::class, 'getFutureTradeExchangeMarketDetailsApp']);
            });
        });
        
        // Currency trade routes with authentication
        Route::group(['namespace' => 'Api\User', 'middleware' => ['auth:api', 'api-user', 'last_seen']], function () {
            Route::get('wallet-currency-deposit', [DepositController::class, 'getCurrencyDepositPageData']);
            Route::post('wallet-currency-deposit', [DepositController::class, 'currencyWalletDepositProcess']);
            Route::get('wallet-currency-deposit-history', [DepositController::class, 'currencyWalletDepositHistory']);
            Route::get('wallet-currency-withdraw', [FiatWithdrawalController::class, 'getWalletCurrencyWithdrawalPage']);
            Route::post('wallet-currency-withdraw', [FiatWithdrawalController::class, 'fiatWalletWithdrawalProcess']);
            Route::get('wallet-currency-withdraw-history', [FiatWithdrawalController::class, 'fiatWalletWithdrawalHistory']);
        });
        
        // Public API routes
        Route::group(['namespace' => 'Api', 'middleware' => ['checkApi']], function () {
            Route::get('latest-blog-list', [LandingController::class, 'latestBlogList']);
        });
        
        // User-related API routes with authentication
        Route::group(['namespace' => 'Api\User', 'middleware' => ['auth:api', 'api-user', 'last_seen']], function () {
            Route::get('get-wallet-balance-details', [WalletController::class, 'getWalletBalanceDetails']);
            Route::get('get-api-settings', [ProfileController::class, 'getApiSettings']);
            Route::get('get-api-white-list', [ProfileController::class, 'getApiWhiteList']);
            Route::get('white-list-{id}-{type}-{value}', [ProfileController::class, 'changeApiWhiteListStatus']);
            Route::get('api-white-list-delete-{id}', [ProfileController::class, 'deleteApiWhiteList']);
            Route::post('update-api-settings', [ProfileController::class, 'updateApiSettings']);
            Route::post('add-api-white-list', [ProfileController::class, 'addApiWhiteList']);
        });

        // api Secret key checker supported list
        Route::group(['namespace' => 'Api\User', 'middleware' => ['apiSecretCheck', 'auth:api', 'api-user', 'publicApiCheck', 'privateIpRate', 'last_seen']], function () {
            Route::get('profile', [ProfileController::class, 'profile']);
        
            // Wallet
            Route::get('wallet-list', [WalletController::class, 'walletList']);
            Route::get('wallet-deposit-{id}', [WalletController::class, 'walletDeposit']);
            Route::get('wallet-withdrawal-{id}', [WalletController::class, 'walletWithdrawal']);
            Route::post('wallet-withdrawal-process', [WalletController::class, 'walletWithdrawalProcess'])->middleware('kycVerification:kyc_withdrawal_setting_status');
            Route::post('pre-withdrawal-process', [WalletController::class, 'preWithdrawalProcess']);
            Route::post('get-wallet-network-address', [WalletController::class, 'getWalletNetworkAddress']);
        
            // Dashboard and reports
            Route::get('get-all-buy-orders-app', [ExchangeController::class, 'getExchangeAllBuyOrdersApp'])->name('getExchangeAllBuyOrdersApp');
            Route::get('get-all-sell-orders-app', [ExchangeController::class, 'getExchangeAllSellOrdersApp'])->name('getExchangeAllSellOrdersApp');
        
            Route::get('get-my-all-orders-app', [ExchangeController::class, 'getMyExchangeOrdersApp'])->name('getMyExchangeOrdersApp');
            Route::get('get-my-trades-app', [ExchangeController::class, 'getMyExchangeTradesApp'])->name('getMyExchangeTradesApp');
            Route::post('cancel-open-order-app', [ExchangeController::class, 'deleteMyOrderApp'])->name('deleteMyOrderApp');
            Route::get('all-buy-orders-history-app', [ReportController::class, 'getAllOrdersHistoryBuyApp'])->name('getAllOrdersHistoryBuyApp');
            Route::get('all-sell-orders-history-app', [ReportController::class, 'getAllOrdersHistorySellApp'])->name('getAllOrdersHistorySellApp');
            Route::get('all-transaction-history-app', [ReportController::class, 'getAllTransactionHistoryApp'])->name('getAllTransactionHistoryApp');
            Route::get('get-all-stop-limit-orders-app', [ReportController::class, 'getExchangeAllStopLimitOrdersApp'])->name('getExchangeAllStopLimitOrdersApp');
            Route::get('referral-history', [ReportController::class, 'getReferralHistory']);
        
            Route::get('wallet-history-app', [WalletController::class, 'walletHistoryApp'])->name('walletHistoryApp');
        
            Route::post('buy-limit-app', [BuyOrderController::class, 'placeBuyLimitOrderApp'])->name('placeBuyLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('buy-market-app', [BuyOrderController::class, 'placeBuyMarketOrderApp'])->name('placeBuyMarketOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('buy-stop-limit-app', [BuyOrderController::class, 'placeBuyStopLimitOrderApp'])->name('placeBuyStopLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('sell-limit-app', [SellOrderController::class, 'placeSellLimitOrderApp'])->name('placeSellLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('sell-market-app', [SellOrderController::class, 'placeSellMarketOrderApp'])->name('placeSellMarketOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('sell-stop-limit-app', [SellOrderController::class, 'placeStopLimitSellOrderApp'])->name('placeStopLimitSellOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
        });
        
        // Additional routes
        Route::group(['namespace' => 'Api\User', 'middleware' => ['apiSecretCheck', 'auth:api', 'api-user', 'last_seen']], function () {
            Route::get('get-networks-list', [TransactionDepositController::class, 'getNetwork']);
            Route::get('get-coin-network', [TransactionDepositController::class, 'getCoinNetwork']);
            Route::post('check-coin-transaction', [TransactionDepositController::class, 'checkCoinTransaction']);
        });
    });
});
