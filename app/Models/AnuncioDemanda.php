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
        'id',
        'titulo',
        'descripcion',
        'user_id',
        'created_at'
    ];

    public function anuncios() {
		return $this->hasOne(Anuncio::class);
	}

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
