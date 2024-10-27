<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TradeSettingController;
use App\Http\Controllers\admin\ReportController;

// Trade
Route::group(['group' => 'coin_pair'], function () {
    Route::get('trade/coin-pairs', [TradeSettingController::class, 'coinPairs'])->name('coinPairs');
    Route::get('trade/coin-pairs-chart-update/{id}', [TradeSettingController::class, 'coinPairsChartUpdate'])->name('coinPairsChartUpdate');
    Route::get('trade/trade-fees-settings', [TradeSettingController::class, 'tradeFeesSettings'])->name('tradeFeesSettings');
    Route::get('trade/future-coin-pair-setting-{id}', [TradeSettingController::class, 'coinPairFutureSetting'])->name('coinPairFutureSetting');
});

Route::group(['middleware' => 'check_demo', 'group' => 'coin_pair'], function () {
    Route::get('trade/coin-pairs-delete/{id}', [TradeSettingController::class, 'coinPairsDelete'])->name('coinPairsDelete');
    Route::post('trade/save-coin-pair', [TradeSettingController::class, 'saveCoinPairSettings'])->name('saveCoinPairSettings');
    Route::post('trade/change-coin-pair-status', [TradeSettingController::class, 'changeCoinPairStatus'])->name('changeCoinPairStatus');
    Route::post('trade/change-coin-pair-default-status', [TradeSettingController::class, 'changeCoinPairDefaultStatus'])->name('changeCoinPairDefaultStatus');
    Route::post('trade/change-coin-pair-bot-status', [TradeSettingController::class, 'changeCoinPairBotStatus'])->name('changeCoinPairBotStatus');
    Route::post('trade/save-trade-fees-settings', [TradeSettingController::class, 'tradeFeesSettingSave'])->name('tradeFeesSettingSave');
    Route::post('trade/remove-trade-limit', [TradeSettingController::class, 'removeTradeLimit'])->name('removeTradeLimit');
    Route::post('trade/change-status-future-trade', [TradeSettingController::class, 'changeFutureTradeStatus'])->name('changeFutureTradeStatus');
    Route::post('trade/future-coin-pair-setting-update', [TradeSettingController::class, 'coinPairFutureSettingUpdate'])->name('coinPairFutureSettingUpdate');
});

// Trade Reports
Route::group(['group' => 'buy_order'], function () {
    Route::get('all-buy-orders-history', [ReportController::class, 'adminAllOrdersHistoryBuy'])->name('adminAllOrdersHistoryBuy');
    Route::get('all-buy-orders-history-export', [ReportController::class, 'adminAllOrdersHistoryBuyExport'])->name('adminAllOrdersHistoryBuyExport');
});

Route::group(['group' => 'sell_order'], function () {
    Route::get('all-sell-orders-history', [ReportController::class, 'adminAllOrdersHistorySell'])->name('adminAllOrdersHistorySell');
    Route::get('all-sell-orders-history-export', [ReportController::class, 'adminAllOrdersHistorySellExport'])->name('adminAllOrdersHistorySellExport');
});

Route::group(['group' => 'stop_limit'], function () {
    Route::get('all-stop-limit-orders-history', [ReportController::class, 'adminAllOrdersHistoryStopLimit'])->name('adminAllOrdersHistoryStopLimit');
});

Route::group(['group' => 'transaction'], function () {
    Route::get('all-transaction-history', [ReportController::class, 'adminAllTransactionHistory'])->name('adminAllTransactionHistory');
    Route::get('all-transaction-history-export', [ReportController::class, 'adminAllTransactionHistoryExport'])->name('adminAllTransactionHistoryExport');
});

Route::group(['group' => 'trade_referral'], function () {
    Route::get('all-trade-referral-history', [ReportController::class, 'adminAllTradeReferralHistory'])->name('adminAllTradeReferralHistory');
});
