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
     * 
     * @return User
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    /**
     * Get anuncio favorito
     * @return Anuncio
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'anuncio_id');
    }
}
