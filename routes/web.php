<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['middleware'=> 'installation'], function () {
    Route::group(['middleware'=> 'default_lang'], function () {

        Route::get('testcase', [AuthController::class, 'test'])->name('testAuth');
        Route::get('/', [AuthController::class, 'login'])->name('login2');
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login-process', [AuthController::class, 'loginProcess'])->name('loginProcess');
        Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
        Route::get('verify-email', [AuthController::class, 'verifyEmailPost'])->name('verifyWeb');
        Route::get('reset-password', [AuthController::class, 'resetPasswordPage'])->name('resetPasswordPage');
        Route::post('send-forgot-mail', [AuthController::class, 'sendForgotMail'])->name('sendForgotMail');
        Route::post('reset-password-save-process', [AuthController::class, 'resetPasswordSave'])->name('resetPasswordSave');

    });

    require base_path('routes/link/admin.php');

    Route::group(['middleware' => ['auth']], function () {
        // Two Factor At Login
        Route::get('/two-factor-check', [AuthController::class, 'g2fChecked'])->name('twofactorCheck');
        Route::post('/two-factor-verify', [AuthController::class, 'twoFactorVerify'])->name('twoFactorVerify');
        Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verifyEmail');
        Route::get('/verify-phone', [AuthController::class, 'verifyPhone'])->name('verifyPhone');

        Route::get('logout', [AuthController::class, 'logOut'])->name('logOut');
    });
});
