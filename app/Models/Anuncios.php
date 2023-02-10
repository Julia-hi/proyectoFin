<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\AnunciosDemanda;

class Anuncios extends Model
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
	 	return $this->belongsTo(AnunciosDemanda::class, 'foreign_key');
	}

    public function anuncioOferta()
	{
	 	return $this->belongsTo(AnunciosOferta::class, 'foreign_key');
	}

}
