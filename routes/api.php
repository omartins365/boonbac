<?php
use App\Http\Controllers\StandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')->group(function ()
{
    Auth::routes();// other auth routes (e.g. register, logout , e.t.c...) already defined by default and matches assessment requirements

    Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    //initial test endpoint
    Route::get('/hello', function ()
    {
        return apiSuccess(message: "Hello World");
    });

    Route::middleware(['auth:sanctum'])->get('/user', function (Request $request)
    {
        return $request->user();
    });
});
