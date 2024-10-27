<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\PaymentMethodController;
use App\Http\Controllers\admin\CurrencyDepositController;
use App\Http\Controllers\admin\FiatWithdrawController;

// Currency management routes
Route::group(['group' => 'currency_list'], function () {
    Route::get('currency-list', [CurrencyController::class, 'adminCurrencyList'])->name('adminCurrencyList');
    Route::get('currency-add', [CurrencyController::class, 'adminCurrencyAdd'])->name('adminCurrencyAdd');
    Route::get('currency-edit-{id}', [CurrencyController::class, 'adminCurrencyEdit'])->name('adminCurrencyEdit');
    Route::get('fiat-currency-list', [CurrencyController::class, 'adminFiatCurrencyList'])->name('adminFiatCurrencyList');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::get('currency-rate-change', [CurrencyController::class, 'adminCurrencyRate'])->name('adminCurrencyRate');
        Route::post('currency-save-process', [CurrencyController::class, 'adminCurrencyAddEdit'])->name('adminCurrencyStore');
        Route::post('currency-status-change', [CurrencyController::class, 'adminCurrencyStatus'])->name('adminCurrencyStatus');
        Route::post('currency-all', [CurrencyController::class, 'adminAllCurrency'])->name('adminAllCurrency');
        Route::get('fiat-currency-delete-{id}', [CurrencyController::class, 'adminFiatCurrencyDelete'])->name('adminFiatCurrencyDelete');
        Route::post('fiat-currency-save-process', [CurrencyController::class, 'adminFiatCurrencySaveProcess'])->name('adminFiatCurrencySaveProcess');
        Route::post('withdrawal-currency-status-change', [CurrencyController::class, 'adminWithdrawalCurrencyStatus'])->name('adminWithdrawalCurrencyStatus');
    });
});

// Currency payment method routes
Route::group(['group' => 'payment_method_list'], function () {
    Route::get('currency-payment-method', [PaymentMethodController::class, 'currencyPaymentMethod'])->name('currencyPaymentMethod');
    Route::get('currency-payment-method-add', [PaymentMethodController::class, 'currencyPaymentMethodAdd'])->name('currencyPaymentMethodAdd');
    Route::get('currency-payment-method-edit-{id}', [PaymentMethodController::class, 'currencyPaymentMethodEdit'])->name('currencyPaymentMethodEdit');

    Route::group(['middleware' => 'check_demo'], function () {
        Route::post('currency-payment-method-store', [PaymentMethodController::class, 'currencyPaymentMethodStore'])->name('currencyPaymentMethodStore');
        Route::post('currency-payment-method-status', [PaymentMethodController::class, 'currencyPaymentMethodStatus'])->name('currencyPaymentMethodStatus');
        Route::get('currency-payment-method-delete-{id}', [PaymentMethodController::class, 'currencyPaymentMethodDelete'])->name('currencyPaymentMethodDelete');
    });
});

// Currency deposit routes
Route::group(['group' => 'pending_deposite_list'], function () {
    Route::get('currency-deposit-list', [CurrencyDepositController::class, 'currencyDepositList'])->name('currencyDepositList');
    Route::get('currency-deposit-pending-list', [CurrencyDepositController::class, 'currencyDepositPendingList'])->name('currencyDepositPendingList');
    Route::get('currency-deposit-accept-list', [CurrencyDepositController::class, 'currencyDepositAcceptList'])->name('currencyDepositAcceptList');
    Route::get('currency-deposit-reject-list', [CurrencyDepositController::class, 'currencyDepositRejectList'])->name('currencyDepositRejectList');
    Route::get('currency-deposit-accept-{id}', [CurrencyDepositController::class, 'currencyDepositAccept'])->name('currencyDepositAccept')->middleware('check_demo');
    Route::post('currency-deposit-reject', [CurrencyDepositController::class, 'currencyDepositReject'])->name('currencyDepositReject')->middleware('check_demo');
});

// Fiat Withdraw routes
Route::group(['group' => 'fiat_withdraw_list'], function () {
    Route::get('fiat-withdraw-list', [FiatWithdrawController::class, 'fiatWithdrawList'])->name('fiatWithdrawList');
    Route::post('fiat-withdraw-accept', [FiatWithdrawController::class, 'fiatWithdrawAccept'])->name('fiatWithdrawAccept')->middleware('check_demo');
    Route::post('fiat-withdraw-reject', [FiatWithdrawController::class, 'fiatWithdrawReject'])->name('fiatWithdrawReject')->middleware('check_demo');
    Route::get('fiat-withdraw-pending-list', [FiatWithdrawController::class, 'fiatWithdrawPendingList'])->name('fiatWithdrawPendingList');
    Route::get('fiat-withdraw-reject-list', [FiatWithdrawController::class, 'fiatWithdrawRejectList'])->name('fiatWithdrawRejectList');
    Route::get('fiat-withdraw-active-list', [FiatWithdrawController::class, 'fiatWithdrawActiveList'])->name('fiatWithdrawActiveList');
    Route::get('withdrawl-paymment-method', [FiatWithdrawController::class, 'getWithdrawlPaymentMethod'])->name('getWithdrawlPaymentMethod');
    Route::get('withdrawl-paymment-method-add', [FiatWithdrawController::class, 'getWithdrawlPaymentMethodAdd'])->name('getWithdrawlPaymentMethodAdd');
    Route::get('withdrawl-paymment-method-edit-{id}', [FiatWithdrawController::class, 'getWithdrawlPaymentMethodEdit'])->name('getWithdrawlPaymentMethodEdit');
});
