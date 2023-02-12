<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anuncio;

class AnuncioDemanda extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anuncios_demanda';

    protected $fillable = [
        'titulo',
        'descripcion',
        'id_usuario'
    ];

    public function anuncios() {
		return $this->hasOne(Anuncio::class);
	}
}
