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
        'id',
        'nombre_originale',
        'enlace',
        'anuncio_id'
    ];

    public function anuncio()
	{
        return $this->belongsTo(AnuncioOferta::class, 'anuncio_id');
	}
    
}
