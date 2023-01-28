<?php

use App\Http\Controllers\Api\v1\Public\AboutMeController;
use App\Http\Controllers\Api\v1\Public\GalleryController;
use App\Http\Controllers\Api\v1\Public\PortfolioController;
use App\Http\Controllers\Api\v1\Public\PortfolioHomeController;
use App\Http\Controllers\Api\v1\Public\SectionController;
use App\Http\Controllers\Api\v1\User\UserController;
use App\Http\Controllers\Api\v1\User\UserDeleteController;
use App\Http\Controllers\Api\v1\User\UserPropicController;
use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\UsernameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| public API Routes
|--------------------------------------------------------------------------
*/

// User settings
Route::prefix('users/{user}')
    ->middleware('auth:api')
    ->group(function () {
        Route::patch('/', [
            UserController::class, 'update'
        ]);
        Route::patch('username', [
            UsernameController::class, 'update'
        ]);
        Route::patch('email', [
            EmailController::class, 'update'
        ]);
        Route::post('password', [
            PasswordController::class, 'update'
        ]);
        Route::get('propic', [
            UserPropicController::class, 'show'
        ]);
        Route::post('propic', [
            UserPropicController::class, 'update'
        ]);
        Route::delete('propic', [
            UserPropicController::class, 'destroy'
        ]);
    });

Route::delete('users/{user}',  [
    UserController::class, 'destroy'
])->middleware(['auth:api', 'ability:password.confirm']);

Route::patch('users/{user}/delete', [
    UserDeleteController::class, 'update'
]);

// Portfolio
Route::get(
    'portfolios/{portfolio}',
    [PortfolioController::class, 'show']
);
Route::get(
    'portfolios/{portfolio}/home',
    [PortfolioHomeController::class, 'show']
);

Route::get(
    'portfolios/{portfolio}/galleries/{gallery}',
    [GalleryController::class, 'show']
);
Route::get(
    'portfolios/{portfolio}/about-me',
    [AboutMeController::class, 'show']
);
