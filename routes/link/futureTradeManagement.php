<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FutureTradeController;

// Future trade routes
Route::group(['group' => 'future-trade', 'prefix' => 'future-trade'], function () {
    Route::get('dashboard', [FutureTradeController::class, 'dashboard'])->name('futureTradeDashboard');

    Route::get('wallet-list', [FutureTradeController::class, 'walletList'])->name('futureTradeWalletList');
    Route::get('transfer-list', [FutureTradeController::class, 'transferHistoryList'])->name('futureTradeTransferHistoryList');

    // Future Trade Type    
    Route::get('future-trade-position-history', [FutureTradeController::class, 'getFutureTradePositionHistory'])->name('futureTradePosition');
    Route::get('future-trade-open-order-history', [FutureTradeController::class, 'getFutureTradeOpenOrderHistory'])->name('getFutureTradeOpenOrderHistory');
    Route::get('future-trade-order-history', [FutureTradeController::class, 'getFutureTradeOrderHistory'])->name('getFutureTradeOrderHistory');
    Route::get('future-trade-history', [FutureTradeController::class, 'getFutureTradeList'])->name('getFutureTradeHistory');
    Route::get('get-future-trade-{id?}', [FutureTradeController::class, 'getFutureTradeDetails'])->name('futureTradeDetails');

    // Future Trade Transaction History
    Route::get('future-trade-transaction-history-{type?}', [FutureTradeController::class, 'getFutureTradeTransactionHistory'])->name('futureTradeTransactionHistory');
    Route::get('get-future-trade-transaction-{id?}', [FutureTradeController::class, 'getFutureTradeTransactionDetails'])->name('futureTradeTransactionDetails');
});
