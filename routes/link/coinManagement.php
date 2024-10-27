<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CoinController;
use App\Http\Controllers\admin\WalletController;

// Coin management routes
Route::group(['group' => 'coin_list'], function () {
    Route::get('total-user-coin', [CoinController::class, 'adminUserCoinList'])->name('adminUserCoinList');
    Route::get('coin-list', [CoinController::class, 'adminCoinList'])->name('adminCoinList');
    Route::get('add-new-coin', [CoinController::class, 'adminAddCoin'])->name('adminAddCoin');
    Route::get('coin-edit/{id}', [CoinController::class, 'adminCoinEdit'])->name('adminCoinEdit');
    Route::get('coin-settings/{id}', [CoinController::class, 'adminCoinSettings'])->name('adminCoinSettings');
    Route::post('check-wallet-address', [CoinController::class, 'check_wallet_address'])->name('check_wallet_address');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::get('coin-delete/{id}', [CoinController::class, 'adminCoinDelete'])->name('adminCoinDelete');
        Route::get('change-coin-rate', [CoinController::class, 'adminCoinRate'])->name('adminCoinRate');
        Route::get('adjust-bitgo-wallet/{id}', [CoinController::class, 'adminAdjustBitgoWallet'])->name('adminAdjustBitgoWallet');
        Route::post('save-new-coin', [CoinController::class, 'adminSaveCoin'])->name('adminSaveCoin');
        Route::post('save-coin-settings', [CoinController::class, 'adminSaveCoinSetting'])->name('adminSaveCoinSetting');
        Route::post('coin-save-process', [CoinController::class, 'adminCoinSaveProcess'])->name('adminCoinSaveProcess');
        Route::post('change-coin-status', [CoinController::class, 'adminCoinStatus'])->name('adminCoinStatus');
        Route::get('coin-make-listed-{id}', [CoinController::class, 'coinMakeListed'])->name('coinMakeListed');
        Route::get('change-demo-trade-status-{coin_type?}', [CoinController::class, 'demoTradeCoinStatus'])->name('demoTradeCoinStatus');

        Route::post('update-wallet-key', [CoinController::class, 'updateWalletKey'])->name('updateWalletKey');
        Route::post('view-wallet-key', [CoinController::class, 'viewWalletKey'])->name('viewWalletKey');
    });
});

// Wallet management routes
Route::group(['group' => 'wallet_list'], function () {
    Route::get('wallet-list', [WalletController::class, 'adminWalletList'])->name('adminWalletList');
    Route::get('my-wallet-list', [WalletController::class, 'myWalletList'])->name('myWalletList');
    Route::get('wallet-address-list', [WalletController::class, 'walletAddressList'])->name('walletAddressList');
    Route::get('deduct-wallet-balance-{wallet_id}', [WalletController::class, 'deductWalletBalance'])->name('deductWalletBalance');
    Route::post('update-deduct-wallet-balance', [WalletController::class, 'deductWalletBalanceSave'])->name('deductWalletBalanceSave');
    Route::get('wallet-list-export', [WalletController::class, 'adminWalletListExport'])->name('adminWalletListExport');
});

// Sending wallet routes
Route::group(['group' => 'send_wallet'], function () {
    Route::get('send-wallet-balance', [WalletController::class, 'adminSendWallet'])->name('adminSendWallet');
    Route::get('active-user-list', [WalletController::class, 'adminActiveUserList'])->name('adminActiveUserList');
    Route::get('send-coin-list', [WalletController::class, 'adminWalletSendList'])->name('adminWalletSendList');
});

// Swap coin history
Route::group(['group' => 'swap_coin_history'], function () {
    Route::get('swap-coin-history', [WalletController::class, 'adminSwapCoinHistory'])->name('adminSwapCoinHistory');
});

// Demo check for sending wallet routes
Route::group(['middleware' => 'check_demo', 'group' => 'send_wallet'], function () {
    Route::post('admin-send-balance-process', [WalletController::class, 'adminSendBalanceProcess'])->name('adminSendBalanceProcess');
    Route::get('admin-send-balance-delete-{id}', [WalletController::class, 'adminSendBalanceDelete'])->name('adminSendBalanceDelete');
});

// Bitgo Webhook
Route::post('bitgo-webhook-save', [CoinController::class, 'webhookSave'])->name('webhookSave');
