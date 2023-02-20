<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use App\Models\Mensaje;

class Anuncio extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anuncios';

    protected $fillable = [
        'id',
        'user_id',
        'estado',
        'tipo',
        'created_ad',
    ];

    function usuario()
	{
	 	return $this->hasOne(User::class);
	}

    public function anuncioDemanda()
	{
	 	return $this->hasOne(AnuncioDemanda::class,'id');
	}

    public function anuncioOferta()
	{
	 	return $this->hasOne(AnuncioOferta::class,'id');
	}
    
    public function mensajes()
	{
	 	return $this->belongsTo(Mensaje::class, 'foreign_key');
	}

    /**
     * favoritos a que pertenece anuncio concreto
     * @return Object
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'anuncio_id');
    }

    public function esFavorito(User $user, Anuncio $anuncio)
    {
        return $user->favoritos()->where('anuncio_id', $anuncio->id)->exists();
    }
}
