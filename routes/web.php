<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController; 
use App\Http\Controllers\UserController; 

use App\Http\Controllers\Anuncios\OfertasController;
use App\Http\Controllers\Anuncios\DemandasController;
use App\Http\Controllers\Anuncios\MapaController;
use App\Http\Controllers\Anuncios\BuscarOfertasController; 
use App\Http\Controllers\UserAnuncios\UserAnunciosController; 
use App\Http\Controllers\UserAnuncios\UserAnuncioOfertaController;
use App\Http\Controllers\UserAnuncios\UserAnuncioDemandaController;
use App\Http\Controllers\UserAnuncios\FotosController;
use App\Http\Controllers\UserFavoritosController;
use App\Http\Controllers\UserMensajesController; //EnviarMensajeController
use App\Http\Controllers\EnviarMensajeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminAnunciosController;
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
    Route::resource('user.anuncios', UserAnunciosController::class);
    Route::resource('oferta.fotos', FotosController::class);
    Route::resource('user.anuncios-oferta', UserAnuncioOfertaController::class);
    Route::resource('user.anuncios-demanda', UserAnuncioDemandaController::class);
    Route::resource('user.favoritos', UserFavoritosController::class);
    Route::resource('user.mensajes', UserMensajesController::class);
    Route::post('/user/{user_id}/mensaje', [EnviarMensajeController:: class, 'sendMessage'])->name('enviarMensaje');
    Route::resource('admin.users', AdminUsersController::class);
    Route::resource('admin.anuncios', AdminAnunciosController::class);
    Route::get('admin-dashboard',[AdminController::class,'index'])->name('admin');
});

Route::get('/ofertas-filter', [BuscarOfertasController::class, 'index'])->name('filter.index');
Route::resource('ofertas', OfertasController::class)->only('index','show');
Route::get('/ofertas/filter', [OfertasController::class, 'filter'])->name('ofertas.filter');
Route::resource('mapa', MapaController::class)->only('index','show');
Route::resource('demandas', DemandasController::class)->only('index','show');

Route::fallback(function(){
    return "Pagina no existe.";
});

require __DIR__.'/auth.php';
