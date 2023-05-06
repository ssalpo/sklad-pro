<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NomenclatureArrivalController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\NomenclatureOperationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\StorehouseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('showcases', ShowcaseController::class);

    Route::resource('users', UserController::class);

    Route::resource('nomenclatures', NomenclatureController::class);

    Route::resource('clients', ClientController::class);

    Route::resource('nomenclature-arrivals', NomenclatureArrivalController::class);

    Route::resource('orders', OrderController::class);

    Route::resource('nomenclature-operations', NomenclatureOperationController::class);

    Route::get('storehouse-balance', [StorehouseController::class, 'index'])->name('storehouse-balance');
});

// Autocomplete routes
Route::group(['prefix' => 'autocomplete', 'as' => 'autocomplete.'], static function () {
    Route::get('nomenclatures', [AutocompleteController::class, 'nomenclatures'])->name('nomenclatures');
    Route::get('clients', [AutocompleteController::class, 'clients'])->name('clients');
    Route::get('showcases', [AutocompleteController::class, 'showcases'])->name('showcases');
})->middleware(['auth:sanctum']);

// Auth
Route::controller(LoginController::class)->group(static function () {
    Route::get('/', 'create')->name('login')->middleware('guest');
    Route::post('login', 'store')->middleware('guest');
    Route::delete('logout', 'destroy')->name('logout');
});
