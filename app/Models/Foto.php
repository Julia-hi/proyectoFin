<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnuncioOferta;

class Foto extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fotos';

    protected $fillable = [
        'nombre_originale',
        'enlace',
        'id_anuncio'
    ];

    public function anuncio()
	{
        return $this->belongsTo(AnuncioOferta::class, 'id_anuncio');
	}
    
}
