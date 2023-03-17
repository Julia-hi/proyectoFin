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

    /**
     * Campos del modelo anuncio relacionados con DB
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'estado',
        'tipo',
        'created_at',
        'updated_at'
    ];

    /**
     * Obreter usuario del anuncio (autor)
     * @return User
     */
    function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener anuncio demanda (es unico)
     * @return AnuncioDemanda
     */
    public function anuncioDemanda()
    {
        return $this->hasOne(AnuncioDemanda::class, 'id');
    }

    /**
     * Obtener anuncio de oferta (es unico)
     * 
     * @return AnuncioOferta
     */
    public function anuncioOferta()
    {
        return $this->hasOne(AnuncioOferta::class, 'id');
    }

    /**
     * Obtener mensajes del anuncio
     * 
     * @return collection
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'anuncio_id');
    }

    /**
     * favoritos a que pertenece anuncio concreto
     * @return Object
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'anuncio_id');
    }

    /**
     * Validar si anuncio ya añadido a favoritos
     * @return bool
     */
    public function esFavorito(User $user, Anuncio $anuncio)
    {
        return $user->favoritos()->where('anuncio_id', $anuncio->id)->exists();
    }
}
