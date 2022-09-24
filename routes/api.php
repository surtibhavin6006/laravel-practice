<?php

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('event',[\App\Http\Controllers\Api\EventController::class,'create'])->name('api.event.create');
Route::put('event/{id}',[\App\Http\Controllers\Api\EventController::class,'update'])->name('api.event.update');
Route::delete('event/{id}',[\App\Http\Controllers\Api\EventController::class,'delete'])->name('api.event.delete');
Route::get('event/{id}',[\App\Http\Controllers\Api\EventController::class,'view'])->name('api.event.view');
Route::get('events',[\App\Http\Controllers\Api\EventController::class,'all'])->name('api.event.list');
Route::get('event/{id}/history',[\App\Http\Controllers\Api\EventController::class,'viewEventHistory'])->name('api.event.history');
