<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnunciosOferta extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anuncios_oferta';

    protected $fillable = [
        'titulo',
        'descripcion',
        'rasa',
        'genero',
        'fecha_nac',
        'com_autonoma',
        'provincia',
        'localidad',
        'lat',
        'lon',
        'id_usuario'
    ];
    
    /**
     * Relacion uno/uno
     * @return Anuncios
     */
    public function anuncios()
    {
        return $this->hasOne(Anuncios::class);
    }
}
