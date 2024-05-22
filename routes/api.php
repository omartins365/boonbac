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


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function ()
{
    //initial test endpoint
    Route::get('/hello', function ($id)
    {
        return apiSuccess(message: "Hello World");
    });

    Route::get('/', function (Request $request)
    {
        return $request->user();
    });
});
