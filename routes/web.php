<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/* Route::controller(AnuncioController::class)->group(function () {
    Route::get('/ofertas/lista/{area}', 'show', function($area){
        return view('of-lista', ['area'=>$area]);
    });
    Route::post('/ofertas', 'store');
}); */

Route::get('/ofertas/lista/{area}', [AnuncioController::class, 'index']);

Route::get('/anuncio/crear', [AnuncioController::class, 'create'])->middleware('auth')->name('anuncio.create');

Route::post('/anuncio/crear', [AnuncioController::class, 'store'])->name('anuncio.store');


Route::get('/mapa/{area}', function($area){
    return view('mapa', ['area'=>$area]);
});

Route::get('/demandas', function(){
    return view('demandas');
});

require __DIR__.'/auth.php';
