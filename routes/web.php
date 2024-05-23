<?php
use App\Http\Controllers\Auth\OAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
//run artisan route:list to confirm endpoints
Auth::routes();// other auth routes (e.g. register, logout , e.t.c...) already defined by default and matches assessment requirements

Route::get( '/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::middleware(['auth'])->group(function ()
{
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});



        Route::get('oauth/{driver}', [OAuthController::class, 'redirectToAuthProvider'])->name('oauth.init');
        Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleAuthProviderCallback'])->name('oauth.callback');
