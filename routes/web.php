<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\LongueursController;
use App\Http\Controllers\ProduitsController;
use App\Http\Controllers\StocksController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('index', [CustomAuthController::class, 'dashboard']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin']);
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('index');
    }
    return view('login');
});

Route::resource('produit', ProduitsController::class);
Route::resource('gestion', CommandesController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('longueurs', LongueursController::class);
Route::resource('clients', ClientsController::class);
Route::resource('stocks', StocksController::class);

Route::post('/produits/{id}/update-stock', [StocksController::class, 'updateStock'])
    ->name('produits.updateStock');

