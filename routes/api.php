<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;


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


//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');
// Route::get('forgot-password', [PasswordResetLinkController::class, 'create']);

Route::post('/forgot-password', [App\Http\Controllers\API\AuthController::class, 'forgotPassword'])->name('forgot-password');
// Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::post('/reset-password', [App\Http\Controllers\API\AuthController::class, 'resetPassword'])
                ->name('reset-password');

// Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//                 ->name('password.reset');

// Route::post('reset-password', [NewPasswordController::class, 'store'])
//                 ->name('password.update');

// Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//                 ->name('password.confirm');

// Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

//For Blog APi Controller

Route::post('/getAllBlog', [App\Http\Controllers\API\AuthController::class, 'index']);

Route::post('/createNewBlog', [App\Http\Controllers\API\AuthController::class, 'createNewBlog']);


Route::post('/destroyBlog/{id}', [App\Http\Controllers\API\AuthController::class, 'destroyBlog']);

Route::get('/editBlog/{id}', [App\Http\Controllers\API\AuthController::class, 'editBlog']);


Route::put('/updateBlog/{id}',[App\Http\Controllers\API\AuthController::class,'updateBlog']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




