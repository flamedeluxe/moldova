<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{alias}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/publications/{alias}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::get('/login', [AccountController::class, 'login'])->name('login');
Route::get('/restore-password', [AccountController::class, 'restorePassword'])->name('restore-password');
Route::get('/register', [AccountController::class, 'register'])->name('register');


