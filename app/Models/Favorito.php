<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnuncioOferta;
use App\Models\User;

class Favorito extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_usuario',
        'id_anuncio'   
    ];

    /**
     * Get user de favorito
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Get user de favorito
     */
    public function anuncio()
    {
        return $this->belongsTo(AnuncioOferta::class, 'id_usuario');
    }
}
