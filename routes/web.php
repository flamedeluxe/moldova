<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\AuthClient;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/publications/{slug}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/region/{slug}', [RegionController::class, 'index'])->name('region');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::get('/login', [AccountController::class, 'login'])->name('login');
Route::get('/restore-password', [AccountController::class, 'restorePassword'])->name('restore-password');
Route::get('/register', [AccountController::class, 'register'])->name('register');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::group(['middleware' => [AuthClient::class], 'as' => 'account.'], function () {
    Route::get('/account', [\App\Http\Controllers\Account\IndexController::class, 'index'])->name('index');
});


Route::fallback([ErrorController::class, 'show404']);
