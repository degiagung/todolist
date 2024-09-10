<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// Route::middleware(['auth'])->group(function () { // harus login terlebih dahulu
    Route::get('/checklist', [ApiController::class, 'checklist']);
    Route::post('/checklist', [ApiController::class, 'createchecklist']);
    Route::delete('/checklist/{id}', [ApiController::class, 'deletechecklist']);
    Route::get('/checklist/{id}/item', [ApiController::class, 'checklistitem']);
    Route::post('/checklist/{id}/item', [ApiController::class, 'createchecklistitem']);
    Route::get('/checklist/{id}/item/{iditem}', [ApiController::class, 'checklistitembychekid']);
    Route::put('/checklist/{id}/item/{iditem}', [ApiController::class, 'updatechecklistitem']);
    Route::delete('/checklist/{id}/item/{iditem}', [ApiController::class, 'deletechecklistitem']);
    Route::put('/checklist/{id}/item/rename/{iditem}', [ApiController::class, 'renamechecklistitem']);
    
// });

