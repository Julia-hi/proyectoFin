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
        'id',
        'user_id',
        'anuncio_id' 
    ];

    /**
     * Get user de favorito
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    /**
     * Get user de favorito
     */
    public function anuncio()
    {
        return $this->belongsTo(AnuncioOferta::class, 'anuncio_id');
    }
}
