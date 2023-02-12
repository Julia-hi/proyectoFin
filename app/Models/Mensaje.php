<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anuncio;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_anuncio',
        'id_destino', // id de usuario propietario del anuncio
        'id_remitente', //id de user que envia mensaje
        'texto'   
    ];

    public function mensajes()
	{
	 	return $this->belongsTo(Anuncio::class, 'foreign_key');
	}
}
