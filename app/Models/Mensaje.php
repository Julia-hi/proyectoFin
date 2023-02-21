<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anuncio;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'anuncio_id',
        'user_id', // usuario autor del mensaje
        'texto',
        'created_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mensajes';
    
    /**
     * Obtener anuncio a qual pertenece il mansaje
     * @return Anuncio
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'anuncio_id');
    }

    /**
     * Obtener id del usuario autor del mensaje
     * @return User
     */
    public function usuario()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    
}
