<?php

use App\Http\Controllers\MobileController;
use App\Http\Controllers\MobileRefServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. TheseAAAAAAAAAA
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', [\App\Http\Controllers\MobileController::class, 'loadClass']);
//Route::get('/', [\App\Http\Controllers\MobileController::class, 'loadAttributes']);
Route::get('/', [\App\Http\Controllers\MobileController::class, 'getData']);
Route::get('/dropdown', [\App\Http\Controllers\MobileController::class, 'getData']);
Route::get('/category_make/{lang}', '\App\Http\Controllers\MobileController@getCategoryAndMake');
Route::get('/model/{lang}/{class}', '\App\Http\Controllers\MobileController@getModel');
Route::get('/make/{lang}/{class}', '\App\Http\Controllers\MobileController@getModelOfModelGroup');
Route::get('/modelRange-trimLine/{lang}/{class}/{make}', '\App\Http\Controllers\MobileController@getModelRange');
Route::get('/models', [\App\Http\Controllers\MobileController::class, 'getAllModels']);

Route::get('/models', [\App\Http\Controllers\MobileController::class, 'getAllModels']);
Route::get('/packages/{model}', [\App\Http\Controllers\MobileController::class, 'getPackage']);
Route::get('/categories', [\App\Http\Controllers\MobileController::class, 'getCategories']);
Route::get('/carSeals', [MobileController::class, 'getUsedCarSeals']);
Route::get('/features', [MobileController::class, 'getFeatures']);
Route::get('/attributes/{attribute}', [MobileController::class, 'getAttributes']);
