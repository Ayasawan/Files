<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;


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


Route::group([
 
    'middleware' => 'api',
    'prefix' => 'auth'
 
], function ($router) {
    Route::post('/registerS', [AuthController::class, 'registerS']);
    Route::post('/registerM', [AuthController::class, 'registerM']);
    Route::post('/registerT', [AuthController::class, 'registerT']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/allUser', [AuthController::class, 'index']);


//Files
    
   Route::post('uploadFile', [FileController::class, 'uploadFile']);
   Route::post('reserveFile/{id}', [FileController::class, 'reserveFile']);
   Route::post('reserveFiles', [FileController::class, 'reserveFiles']);
   Route::get('indexFiles', [FileController::class, 'indexFiles']);
   Route::get('indexFilesbyPer', [FileController::class, 'indexFilesbyPer']);
   Route::post('ReplaceFile/{id}', [FileController::class, 'ReplaceFile']);

 //Add Group
   
   Route::post('AddGroup', [GroupController::class, 'AddGroup']);
   Route::get('indexGroup', [GroupController::class, 'indexGroup']);
   Route::get('indexGroupbyPer', [GroupController::class, 'indexGroupbyPer']);

   

});
