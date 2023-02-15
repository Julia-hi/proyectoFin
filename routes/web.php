<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController; 
use App\Http\Controllers\UserController; 

use App\Http\Controllers\Anuncios\OfertasController;
use App\Http\Controllers\Anuncios\DemandasController;

use App\Http\Controllers\UserAnuncios\UserAnunciosController; //UserAnuncioOfertaController
use App\Http\Controllers\UserAnuncios\UserAnuncioOfertaController;
use App\Http\Controllers\UserAnuncios\UserAnuncioDemandaController;
use App\Http\Controllers\UserFavoritosController;
use App\Http\Controllers\UserMensajesController;
use App\Http\Controllers\WelcomeController;
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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', [WelcomeController::class,'index'])->name('welcome') ;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); //->middleware(['auth', 'verified'])

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class,'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('ofertas', OfertasController::class)->only('index','show');
Route::resource('demandas', DemandasController::class)->only('show');
Route::resource('user.anuncios', UserAnunciosController::class)->middleware('auth');
Route::resource('user.anuncios-oferta', UserAnuncioOfertaController::class)->middleware('auth');
Route::resource('user.anuncios-demanda', UserAnuncioDemandaController::class)->middleware('auth');
Route::resource('user.favoritos', UserFavoritosController::class)->middleware('auth');
Route::resource('user.mensajes', UserMensajesController::class)->middleware('auth');


//Route::get('/anuncio/crear', [AnuncioController::class, 'create'])->middleware('auth')->name('anuncio.create');

/* Route::get('/mapa/{area}', function($area){
    return view('mapa', ['area'=>$area]);
});
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/dashboard', function () {
    return view('admin.home1');
}); */


/* Route::get('/admin', function(){
    return view('admin/dashboard');
})->middleware('auth:admin'); */


/* Route::middleware(['auth:admin'])->group(function () {
    // routes that require admin authentication
    Route::get('/admin/dashboard', [AdminController::class, 'show']);
}); */

/* Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');
}); */

/* Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); */

/* Route::get('/demandas', function(){
    return view('demandas');
}); */

require __DIR__.'/auth.php';
