<?php

use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GetAuthenticatedUserInfo;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
// Route::group(
//     ['middleware' => 'cors'],
//     function () {

        Route::middleware('api')->group(function () {
            Route::post('forgot-password', 'App\Http\Controllers\ForgotPasswordController@forgotPassword')
                ->name('forgot-password');
            Route::post('reset-password', 'App\Http\Controllers\ResetPasswordController@resetPassword')
                    ->name('reset-password');
        });
        Route::group(
            ['prefix' => 'auth', 'namespace' => 'App\Http\Controllers'],
            function () {
                Route::post('pdf', 'TransactionController@generateSoa');
                Route::post('login', 'AuthController@login');
            }
        );
        Route::group(
            ['middleware' => 'auth:api'],
            function () {
                Route::get('me', GetAuthenticatedUserInfo::class)->name('me');
                Route::resource('hub', HubController::class, ['except' => ['create', 'edit']]);
                Route::resource('coordinator', CoordinatorController::class, ['except' => ['create', 'edit']]);
                Route::resource('course', CourseController::class, ['except' => ['create', 'edit']]);
                Route::resource('group', GroupController::class, ['except' => ['create', 'edit']]);
                Route::resource('program', ProgramController::class, ['except' => ['create', 'edit']]);
                Route::resource('school', SchoolController::class, ['except' => ['create', 'edit']]);
                Route::resource('student', StudentController::class, ['except' => ['create', 'edit']]);
                Route::resource('user', UserController::class, ['except' => ['create', 'edit']]);
                Route::resource('transaction', TransactionController::class, ['except' => ['create', 'edit']]);
                Route::get('dashboard', DashboardController::class)->name('dashboard');
            }
        );
    // });
