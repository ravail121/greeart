<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TradingBotController;
use App\Http\Controllers\admin\AddonsController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\TestController;

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin', 'permission', 'default_lang']], function () {

    // Logs
    Route::group(['group' => 'log'], function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('adminLogs');
    });

    Route::group(['group' => 'dashboard'], function () {
        Route::get('test-bot', [TradingBotController::class, 'botOrder'])->name('botOrder');
        Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('adminDashboard');
        Route::get('dashboard-check', [DashboardController::class, 'adminDashboardCheck'])->name('adminDashboardCheck');
        Route::get('pending-withdrawals', [TransactionController::class, 'adminPendingWithdrawal'])->name('adminPendingWithdrawals');
    });
    Route::get('earning-report', [DashboardController::class, 'adminEarningReport'])->name('adminEarningReport');

    // User management
    require base_path('routes/link/userManagement.php');

    // Coin management
    require base_path('routes/link/coinManagement.php');

    // Wallet deposit withdrawal management
    require base_path('routes/link/walletManagement.php');

    // General settings
    require base_path('routes/link/generalSettings.php');

    // Landing settings
    require base_path('routes/link/landingManagement.php');

    // Fiat management
    require base_path('routes/link/fiatManagement.php');

    // Trade management
    require base_path('routes/link/tradeManagement.php');

    // Role management
    require base_path('routes/link/roleManagement.php');

    // Staking management
    require base_path('routes/link/stakingManagement.php');

    // Gift card
    require base_path('routes/link/gift_card.php');

    // Future trade management
    require base_path('routes/link/futureTradeManagement.php');

    // Notification
    Route::group(['group' => 'notify'], function () {
        Route::get('send-notification', [DashboardController::class, 'sendNotification'])->name('sendNotification');
        Route::post('send-notification-process', [DashboardController::class, 'sendNotificationProcess'])->name('sendNotificationProcess');
    });

    // Email
    Route::group(['group' => 'email'], function () {
        Route::get('send-email', [DashboardController::class, 'sendEmail'])->name('sendEmail');
        Route::get('clear-email', [DashboardController::class, 'clearEmailRecord'])->name('clearEmailRecord');
        Route::post('send-email-process', [DashboardController::class, 'sendEmailProcess'])->name('sendEmailProcess')->middleware('check_demo');
    });

});

Route::group(['middleware'=> ['auth', 'lang']], function () {
    Route::get('/send-sms-for-verification', [ProfileController::class, 'sendSMS'])->name('sendSMS');
    Route::get('test', [TestController::class, 'index'])->name('test');
    Route::group(['middleware'=>'check_demo'], function() {
        Route::post('/user-profile-update', [ProfileController::class, 'userProfileUpdate'])->name('userProfileUpdate');
        Route::post('/upload-profile-image', [ProfileController::class, 'uploadProfileImage'])->name('uploadProfileImage');
        Route::post('change-password-save', [ProfileController::class, 'changePasswordSave'])->name('changePasswordSave');
        Route::post('/phone-verify', [ProfileController::class, 'phoneVerify'])->name('phoneVerify');
    });
});

Route::get('/invoice', function(){
    return view('email.template-three.index');
});

// Addon settings
Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin', 'default_lang']], function () {
    Route::group(['group' => 'addons_settings'], function () {
        Route::get('addons-list', [AddonsController::class, 'addonsLists'])->name('addonsLists');
        Route::get('addons-settings', [AddonsController::class, 'addonsSettings'])->name('addonsSettings');
        Route::post('addons-settings-save', [AddonsController::class, 'saveAddonsSettings'])->name('saveAddonsSettings')->middleware('check_demo');
    });
});
