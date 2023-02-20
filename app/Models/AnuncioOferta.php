<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Foto;
use App\Models\Anuncio;
use App\Models\User;
use App\Models\Favorito;
use Illuminate\Support\Facades\DB;

class AnuncioOferta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anuncios_oferta';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'raza',
        'genero',
        'fecha_nac',
        'comunidad',
        'provincia',
        'poblacion',
        'lat',
        'lon',
        'user_id',
        'created_at'
    ];

    /**
     * Obtener anuncio
     * @return Anuncio
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class,'id');
    }


    /**
     * Obtener autor del anuncio oferta
     * @return User
     */
    function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
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
     * Relacion uno/uno
     * @return Foto
     */
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'anuncio_id');
    }


}
