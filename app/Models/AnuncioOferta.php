<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Foto;
use App\Models\Anuncio;

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
        'id_usuario'
    ];
    
    /**
     * Relacion uno/uno
     * @return Anuncio
     */
    public function anuncio()
    {
        return $this->hasOne(Anuncio::class);
    }

    public function favorito()
	{
	 	return $this->belongsTo(Favorito::class, 'foreign_key');
	}

    /**
     * Relacion uno/uno
     * @return Foto
     */
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_anuncio');
    }
    
}
