<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/clubs', function () {
        return view('clubs.index');
    })->name('clubs');

    Route::get('/players', function () {
        return view('players.index');
    })->name('players');


    //Route::resource('clubs', \App\Http\Controllers\ClubController::class);

    Route::get('/clubs/edit/', function ($id) {
        return view('clubs.edit', compact('id'));
    })->name('clubs.edit');

    Route::get('/clubs/delete', function () {
        return view('clubs.delete');
    })->name('clubs.destroy');

   /*  Route::get('/clubs', function ($id) {
        return view('clubs.show', compact('id'));
    })->name('clubs.show'); */


   
});
