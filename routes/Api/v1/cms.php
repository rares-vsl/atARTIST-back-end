<?php

use App\Http\Controllers\Api\v1\CMS\AboutMe\AboutMeController;
use App\Http\Controllers\Api\v1\CMS\CMSController;
use App\Http\Controllers\Api\v1\CMS\Gallery\GalleryArchiveController;
use App\Http\Controllers\Api\v1\CMS\Gallery\GalleryController;
use App\Http\Controllers\Api\v1\CMS\Gallery\GalleryDeleteController;
use App\Http\Controllers\Api\v1\CMS\Gallery\GalleryIndexController;
use App\Http\Controllers\Api\v1\CMS\Portfolio\PortfolioController;
use App\Http\Controllers\Api\v1\CMS\Portfolio\PortfolioDeleteController;
use App\Http\Controllers\Api\v1\CMS\Portfolio\PortfolioIconController;
use App\Http\Controllers\Api\v1\CMS\Portfolio\PortfolioArchiveController;
use App\Http\Controllers\Api\v1\CMS\Portfolio\PortfolioNameController;
use App\Http\Controllers\Api\v1\CMS\Post\PostController;
use Illuminate\Support\Facades\Route;

// BASE ROOT: /v1/cms

/*
    Visualizzazione nome, icona e stato (eliminato e\o archiviato) del portfolio
*/

Route::get('/', [CMSController::class, 'show']);

// Portfolio name available
Route::get('portfolios/name', [PortfolioNameController::class, 'show']);

/*
    - store:  Creazione del portfolio
    - show:   Visualizzazione sezioni del portfolio
    - update: Aggiornamento nome del portfolio
    - delete: Eliminazione temporanea del portfolio

    Se il portfolio è eliminato temporaneamente non è accessibile
    Se il portfolio è archiviato è accessibile
*/
Route::apiResource('portfolios', PortfolioController::class)->except(['index']);

Route::prefix('portfolios/{portfolio}/')
    ->group(function () {
        // Ripristino del portfolio
        Route::patch('delete', [PortfolioDeleteController::class, 'update']);
        // Cancellazione definitiva del portfolio
        Route::delete('delete', [PortfolioDeleteController::class, 'destroy']);
        // Archiviazione del portfolio
        Route::patch('archive', [PortfolioArchiveController::class, 'update']);

        // Modifica icona
        Route::get('icon', [PortfolioIconController::class, 'show']);
        Route::post('icon', [PortfolioIconController::class, 'update']);
        Route::delete('icon', [PortfolioIconController::class, 'destroy']);
    });


Route::get('portfolios/{portfolio}/about-me', [AboutMeController::class, 'show']);
Route::patch('portfolios/{portfolio}/about-me', [AboutMeController::class, 'update']);


Route::get(
    'portfolios/{portfolio}/galleries/deleted',
    [GalleryDeleteController::class, 'index']
);


Route::apiResource(
    'portfolios.galleries',
    GalleryController::class
);


Route::prefix('portfolios/{portfolio}/galleries/{gallery}')
    ->group(function () {
        Route::patch(
            'archive',
            [GalleryArchiveController::class, 'update']
        );
        Route::patch('index', [GalleryIndexController::class, 'update']);
        Route::patch(
            'delete',
            [GalleryDeleteController::class, 'update']
        );
        Route::delete(
            'delete',
            [GalleryDeleteController::class, 'destroy']
        );
    });


Route::apiResource(
    'portfolios.galleries.posts',
    PostController::class
)->except(['update']);

Route::post(
    'portfolios/{portfolio}/galleries/{gallery}/posts/{post}',
    [PostController::class, 'update']
);
