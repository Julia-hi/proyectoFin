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
        'id_usuario',
        'estado',
        'tipo'
    ];

    public function anuncioDemanda()
	{
	 	return $this->belongsTo(AnuncioDemanda::class, 'foreign_key');
	}

    public function anuncioOferta()
	{
	 	return $this->belongsTo(AnuncioOferta::class, 'foreign_key');
	}
    
    public function mensajes()
	{
	 	return $this->belongsTo(Mensaje::class, 'foreign_key');
	}
}
