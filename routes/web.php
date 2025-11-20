<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\VenuesController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AboutController;

Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about/jaffnaicf', [AboutController::class, 'jaffnaicf'])->name('about.jaffnaicf');
Route::get('/about/team', [TeamController::class, 'index'])->name('about.team');
Route::get('/venues', [VenuesController::class, 'index'])->name('venues');
Route::get('/partners', [PartnersController::class, 'index'])->name('partners');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Programme pages (current year image galleries)
Route::prefix('programme')->name('programme.')->group(function () {
    Route::get('/schedule', [ProgrammeController::class, 'schedule'])->name('schedule');
    Route::get('/masterclasses', [ProgrammeController::class, 'masterclasses'])->name('masterclasses');
    Route::get('/debut-films', [ProgrammeController::class, 'debutFilms'])->name('debut-films');
    Route::get('/jury-debut-films', [ProgrammeController::class, 'juryDebut'])->name('jury-debut-films');
    Route::get('/jury-short-films', [ProgrammeController::class, 'juryShort'])->name('jury-short-films');
    Route::get('/national-short-films', [ProgrammeController::class, 'nationalShorts'])->name('national-short-films');
    Route::get('/international-short-films', [ProgrammeController::class, 'internationalShorts'])->name('international-short-films');
    Route::get('/new-asian-currents', [ProgrammeController::class, 'newAsianCurrents'])->name('new-asian-currents');
});

// Archive pages (year-based content)
Route::prefix('archive')->name('archive.')->group(function () {
    Route::get('/', [ArchiveController::class, 'index'])->name('index');
    Route::get('/{year}', [ArchiveController::class, 'index'])->where('year', '[0-9]{4}')->name('year');
    
    Route::get('/{year}/team', [ArchiveController::class, 'team'])->where('year', '[0-9]{4}')->name('team');
    Route::get('/{year}/partners', [ArchiveController::class, 'partners'])->where('year', '[0-9]{4}')->name('partners');
    Route::get('/{year}/venues', [ArchiveController::class, 'venues'])->where('year', '[0-9]{4}')->name('venues');
    
    Route::prefix('{year}/programme')->where(['year' => '[0-9]{4}'])->name('programme.')->group(function () {
        Route::get('/schedule', [ArchiveController::class, 'schedule'])->name('schedule');
        Route::get('/masterclasses', [ArchiveController::class, 'masterclasses'])->name('masterclasses');
        Route::get('/debut-films', [ArchiveController::class, 'debutFilms'])->name('debut-films');
        Route::get('/jury-debut-films', [ArchiveController::class, 'juryDebut'])->name('jury-debut-films');
        Route::get('/jury-short-films', [ArchiveController::class, 'juryShort'])->name('jury-short-films');
        Route::get('/national-short-films', [ArchiveController::class, 'nationalShorts'])->name('national-short-films');
        Route::get('/international-short-films', [ArchiveController::class, 'internationalShorts'])->name('international-short-films');
        Route::get('/new-asian-currents', [ArchiveController::class, 'newAsianCurrents'])->name('new-asian-currents');
    });
});
