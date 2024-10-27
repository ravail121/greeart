<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    SettingsController,
    SMSController,
    LandingController,
    ConfigController,
    AdminLangController,
    BankController,
    CountryController,
    KycController,
    AnalyticsController,
    SeoManagerController,
    TwoFactorController,
    ThemeSettingsController,
    ProgressStatusController,
    OtherSettingController,
    CoinPaymentNetworkFee
};

// FAQ
Route::group(['group' => 'faq'], function () {
    Route::get('faq-list', [SettingsController::class, 'adminFaqList'])->name('adminFaqList');
    Route::get('faq-add', [SettingsController::class, 'adminFaqAdd'])->name('adminFaqAdd');
    Route::get('faq-type-add', [SettingsController::class, 'adminFaqTypeAdd'])->name('adminFaqTypeAdd');
    Route::get('faq-edit-{id}', [SettingsController::class, 'adminFaqEdit'])->name('adminFaqEdit');
    Route::get('faq-type-edit-{id}', [SettingsController::class, 'adminFaqTypeEdit'])->name('adminFaqTypeEdit');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::get('faq-delete-{id}', [SettingsController::class, 'adminFaqDelete'])->name('adminFaqDelete');
        Route::get('faq-type-delete-{id}', [SettingsController::class, 'adminFaqTypeDelete'])->name('adminFaqTypeDelete');
        Route::post('faq-type-save', [SettingsController::class, 'adminFaqTypeSave'])->name('adminFaqTypeSave');
        Route::post('faq-save', [SettingsController::class, 'adminFaqSave'])->name('adminFaqSave');
    });
});

// General Settings
Route::group(['group' => 'general'], function () {
    Route::get('general-settings', [SettingsController::class, 'adminSettings'])->name('adminSettings');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::post('admin-save-common-setting', [SettingsController::class, 'adminSettingsSaveCommon'])->name('adminSettingsSaveCommon');
        Route::post('common-settings', [SettingsController::class, 'adminCommonSettings'])->name('adminCommonSettings');
        Route::post('recaptcha-settings', [SettingsController::class, 'adminCapchaSettings'])->name('adminCapchaSettings');
        Route::post('email-save-settings', [SettingsController::class, 'adminSaveEmailSettings'])->name('adminSaveEmailSettings');
        Route::post('email-template-save-settings', [SettingsController::class, 'adminSaveEmailTemplateSettings'])->name('adminSaveEmailTemplateSettings');
        Route::post('sms-save-settings', [SettingsController::class, 'adminSaveSmsSettings'])->name('adminSaveSmsSettings');
        Route::post('referral-fees-settings', [SettingsController::class, 'adminReferralFeesSettings'])->name('adminReferralFeesSettings');
        Route::post('trade-referral-fees-settings', [SettingsController::class, 'adminTradeReferralFeesSettings'])->name('adminTradeReferralFeesSettings');
        Route::post('cron-save-settings', [SettingsController::class, 'adminSaveCronSettings'])->name('adminSaveCronSettings');
        Route::post('save-wallet-overview-settings', [SettingsController::class, 'adminSaveWalletOverviewSettings'])->name('adminSaveWalletOverviewSettings');
        Route::post('fiat-widthdraw-save-settings', [SettingsController::class, 'adminSaveFiatWithdrawalSettings'])->name('adminSaveFiatWithdrawalSettings');
        Route::post('admin-exchange-layout-setting', [SettingsController::class, 'adminExchangeLayoutSettings'])->name('adminExchangeLayoutSettings');
        Route::post('admin-api-overview-setting', [SettingsController::class, 'adminApiOverviewSettings'])->name('adminApiOverviewSettings');

        Route::post('choose-sms-settings-save', [SMSController::class, 'adminChooseSmsSettings'])->name('adminChooseSmsSettings');
        Route::post('nexmo-settings-save', [SMSController::class, 'adminNexmoSmsSettingsSave'])->name('adminNexmoSmsSettingsSave');
        Route::post('send-test-sms', [SMSController::class, 'adminSendTestSms'])->name('adminSendTestSms');
        Route::post('africa-talk-sms-settings-save', [SMSController::class, 'adminAfricaTalkSmsSettingsSave'])->name('adminAfricaTalkSmsSettingsSave');
        Route::get('remove-image', [SettingsController::class, 'removeAdminImageSettings'])->name('removeAdminImageSettings');
    });
});

// Feature Settings
Route::group(['group' => 'feature_settings'], function () {
    Route::get('admin-feature-settings', [SettingsController::class, 'adminFeatureSettings'])->name('adminFeatureSettings');
    Route::post('admin-cookie-settings-save', [SettingsController::class, 'adminCookieSettingsSave'])->name('adminCookieSettingsSave')->middleware('check_demo');
    Route::get('delete-bot-orders', [SettingsController::class, 'deleteBotOrders'])->name('adminDeleteBotOrders')->middleware('check_demo');
});

// API Settings
Route::group(['group' => 'api_settings'], function () {
    Route::get('api-settings', [SettingsController::class, 'adminCoinApiSettings'])->name('adminCoinApiSettings');
    Route::get('network-fees', [CoinPaymentNetworkFee::class, 'list'])->name('networkFees');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::post('save-payment-settings', [SettingsController::class, 'adminSavePaymentSettings'])->name('adminSavePaymentSettings');
        Route::post('save-bitgo-settings', [SettingsController::class, 'adminSaveBitgoSettings'])->name('adminSaveBitgoSettings');
        Route::post('admin-erc20-api-settings', [SettingsController::class, 'adminSaveERC20ApiSettings'])->name('adminSaveERC20ApiSettings');
        Route::post('admin-other-api-settings', [SettingsController::class, 'adminSaveOtherApiSettings'])->name('adminSaveOtherApiSettings');
        Route::post('admin-stripe-api-settings', [SettingsController::class, 'adminSaveStripeApiSettings'])->name('adminSaveStripeApiSettings');
        Route::post('admin-razorpay-api-settings', [SettingsController::class, 'adminSaveRazorpayApiSettings'])->name('adminSaveRazorpayApiSettings');
        Route::get('network-fees-update', [CoinPaymentNetworkFee::class, 'createOrUpdate'])->name('networkFeesUpdate');
        Route::post('admin-paystack-api-settings', [SettingsController::class, 'adminSavePaystackApiSettings'])->name('adminSavePaystackApiSettings');
        Route::post('currency-exchange-rate-api-update', [SettingsController::class, 'adminSaveCurrencyExchangeApiSettings'])->name('adminSaveCurrencyExchangeApiSettings');
    });
});

// Custom Pages
Route::group(['group' => 'custom_pages'], function () {
    Route::get('custom-page-slug-check', [LandingController::class, 'customPageSlugCheck'])->name('customPageSlugCheck');
    Route::get('custom-page-list', [LandingController::class, 'adminCustomPageList'])->name('adminCustomPageList');
    Route::get('custom-page-add', [LandingController::class, 'adminCustomPageAdd'])->name('adminCustomPageAdd');
    Route::get('custom-page-edit/{id}', [LandingController::class, 'adminCustomPageEdit'])->name('adminCustomPageEdit');
    Route::get('custom-page-order', [LandingController::class, 'customPageOrder'])->name('customPageOrder');
    Route::get('custom-page-delete/{id}', [LandingController::class, 'adminCustomPageDelete'])->name('adminCustomPageDelete')->middleware('check_demo');
    Route::post('custom-page-save', [LandingController::class, 'adminCustomPageSave'])->name('adminCustomPageSave')->middleware('check_demo');
});

// Configuration
Route::group(['group' => 'config'], function () {
    Route::get('admin-config', [ConfigController::class, 'adminConfiguration'])->name('adminConfiguration');
    Route::get('run-admin-command/{type}', [ConfigController::class, 'adminRunCommand'])->name('adminRunCommand')->middleware('check_demo');
});

// Language
Route::group(['group' => 'lang_list'], function () {
    Route::get('lang-list', [AdminLangController::class, 'adminLanguageList'])->name('adminLanguageList');
    Route::get('lang-add', [AdminLangController::class, 'adminLanguageAdd'])->name('adminLanguageAdd');
    Route::get('lang-edit-{id}', [AdminLangController::class, 'adminLanguageEdit'])->name('adminLanguageEdit');
    Route::post('lang-save', [AdminLangController::class, 'adminLanguageSave'])->name('adminLanguageSave')->middleware('check_demo');
    Route::get('lang-delete-{id}', [AdminLangController::class, 'adminLanguageDelete'])->name('adminLanguageDelete')->middleware('check_demo');
    Route::get('lang-synchronize', [AdminLangController::class, 'adminLanguageSynchronize'])->name('adminLanguageSynchronize')->middleware('check_demo');
    Route::post('lang-status-change', [AdminLangController::class, 'adminLangStatus'])->name('adminLangStatus')->middleware('check_demo');
});

// Bank Settings
Route::group(['group' => 'bank_list'], function () {
    Route::get('bank-list', [BankController::class, 'bankList'])->name('bankList');
    Route::get('bank-add', [BankController::class, 'bankAdd'])->name('bankAdd');
    Route::get('bank-edit-{id}', [BankController::class, 'bankEdit'])->name('bankEdit');
    Route::post('bank-save', [BankController::class, 'bankStore'])->name('bankStore')->middleware('check_demo');
    Route::post('bank-status-change', [BankController::class, 'bankStatusChange'])->name('bankStatusChange')->middleware('check_demo');
    Route::get('bank-delete-{id}', [BankController::class, 'bankDelete'])->name('bankDelete')->middleware('check_demo');
});

// Country
Route::group(['group' => 'country_list'], function () {
    Route::get('country-list', [CountryController::class, 'countryList'])->name('countryList');
    Route::post('country-status-change', [CountryController::class, 'countryStatusChange'])->name('countryStatusChange')->middleware('check_demo');
});

// KYC Settings
Route::group(['group' => 'kyc_settings'], function () {
    Route::get('kyc-list', [KycController::class, 'kycList'])->name('kycList');
    Route::post('kyc-status-change', [KycController::class, 'kycStatusChange'])->name('kycStatusChange');
    Route::get('kyc-update-image-{id}', [KycController::class, 'kycUpdateImage'])->name('kycUpdateImage');
    Route::post('kyc-settings', [KycController::class, 'kycSettings'])->name('kycSettings');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::post('send_test_mail', [SettingsController::class, 'testMail'])->name('testmailsend');
        Route::post('kyc-withdrawal-setting', [KycController::class, 'kycWithdrawalSetting'])->name('kycWithdrawalSetting');
        Route::post('kyc-trade-setting', [KycController::class, 'kycTradeSetting'])->name('kycTradeSetting');
        Route::post('kyc-store-image', [KycController::class, 'kycStoreImage'])->name('kycStoreImage');
        Route::post('kyc-persona-settings', [KycController::class, 'kycPersonaSettings'])->name('kycPersonaSettings');
        Route::post('kyc-staking-settings', [KycController::class, 'kycStakingSetting'])->name('kycStakingSetting');
    });
});

// Google Analytics
Route::group(['group' => 'google_analytics'], function () {
    Route::get('google-analytics-add', [AnalyticsController::class, 'googleAnalyticsAdd'])->name('googleAnalyticsAdd');
    Route::post('google-analytics-id-store', [AnalyticsController::class, 'googleAnalyticsIDStore'])->name('googleAnalyticsIDStore')->middleware('check_demo');
});

// SEO Manager
Route::group(['group' => 'seo_manager'], function () {
    Route::get('seo-manager-add', [SeoManagerController::class, 'seoManagerAdd'])->name('seoManagerAdd');
    Route::post('seo-manager-update', [SeoManagerController::class, 'seoManagerUpdate'])->name('seoManagerUpdate')->middleware('check_demo');
});

// Two Factor Settings
Route::group(['group' => 'two_factor'], function () {
    Route::get("two-factor-settings", [TwoFactorController::class, 'index'])->name("twoFactor");
    Route::post("two-factor-settings", [TwoFactorController::class, 'saveTwoFactorList'])->name("SaveTwoFactor")->middleware('check_demo');
    Route::post("two-factor-data", [TwoFactorController::class, 'saveTwoFactorData'])->name("SaveTwoFactorData")->middleware('check_demo');
});

// Theme Settings
Route::group(['group' => 'theme_setting'], function () {
    Route::get('themes-settings', [ThemeSettingsController::class, 'themesSettingsPage'])->name('themesSettingsPage');
    Route::get('theme-settings', [ThemeSettingsController::class, 'addEditThemeSettings'])->name('addEditThemeSettings');
    Route::get('reset-theme-color-settings', [ThemeSettingsController::class, 'resetThemeColorSettings'])->name('resetThemeColorSettings');
    Route::post('theme-navebar-settings-save', [ThemeSettingsController::class, 'themeNavebarSettingsSave'])->name('themeNavebarSettingsSave')->middleware('check_demo');
    Route::post('theme-settings-store', [ThemeSettingsController::class, 'addEditThemeSettingsStore'])->name('addEditThemeSettingsStore')->middleware('check_demo');
    Route::post('themes-settings-save', [ThemeSettingsController::class, 'themesSettingSave'])->name('themesSettingSave')->middleware('check_demo');
});

// Progress Status
Route::group(['group' => 'progress-status-list'], function () {
    Route::get('progress-status-list', [ProgressStatusController::class, 'progressStatusList'])->name('progressStatusList');
    Route::get('progress-status-add', [ProgressStatusController::class, 'progressStatusAdd'])->name('progressStatusAdd');
    Route::get('progress-status-edit/{id}', [ProgressStatusController::class, 'progressStatusEdit'])->name('progressStatusEdit');
    Route::get('progress-status-settings', [ProgressStatusController::class, 'progressStatusSettings'])->name('progressStatusSettings')->middleware('check_demo');
    Route::post('progress-status-settings-update', [ProgressStatusController::class, 'progressStatusSettingsUpdate'])->name('progressStatusSettingsUpdate')->middleware('check_demo');
    Route::get('progress-status-delete/{id}', [ProgressStatusController::class, 'progressStatusDelete'])->name('progressStatusDelete')->middleware('check_demo');
    Route::post('progress-status-save', [ProgressStatusController::class, 'progressStatusSave'])->name('progressStatusSave')->middleware('check_demo');
});

// Other Settings
Route::group(['group'=> 'other_settings'], function () {
    Route::get('other-setting', [OtherSettingController::class, 'otherSetting'])->name('otherSetting');
    Route::get('delete-address', [OtherSettingController::class, 'deleteWalletAddress'])->name('deleteWalletAddress');
    Route::post('check-outside-market-rate', [OtherSettingController::class, 'checkOutsideMarketRate'])->name('checkOutsideMarketRate');
    Route::post('delete-coin-pair-chart-data', [OtherSettingController::class, 'deleteCoinPairChartData'])->name('deleteCoinPairChartData');
    Route::post('delete-coin-order-data', [OtherSettingController::class, 'deleteCoinPairOrderData'])->name('deleteCoinPairOrderData');
    Route::post('update-pair-token', [OtherSettingController::class, 'updatePairWithToken'])->name('updatePairWithToken');
});
