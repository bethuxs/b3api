<?php
use Illuminate\Support\Facades\Route;

Route::prefix('app')->name('app.')->middleware('auth')->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home')
        ->middleware('auth');

    Route::controller(\App\Http\Controllers\Invoices::class)
        ->name('invoices.')
        ->prefix('invoice')
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'edit')->name('create');
        Route::get('/view/{invoice}/{pdf?}', 'view')->name('view');
        Route::post('/store/{invoice?}', 'store')->name('store');
        Route::get('/edit/{invoice}', 'edit')->name('edit');
        Route::get('/delete/{invoice}', 'delete')->name('delete');

        Route::prefix('item')->name('item.')->group(function() {
            Route::get('/delete/{item}', 'delete')->name('delete');
            Route::post('/store/{invoice}/{item?}', 'storeItem')->name('store');
        });
    });

    Route::controller(\App\Http\Controllers\Card::class)
        ->name('cards.')
        ->prefix('cards')
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'edit')->name('create');
        Route::get('/view/{card}', 'view')->name('view');
        Route::post('/store/{card?}', 'store')->name('store');
        Route::get('/edit/{card}', 'edit')->name('edit');
        Route::get('/delete/{card}', 'delete')->name('delete');
    });
});

