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
        'remitente_id', // usuario autor del mensaje
        'recipiente_id',
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
    public function remitente()
    {
        return $this->belongsTo(User::class,'remitente_id');
    }

    /**
     * Obtener id del usuario autor del mensaje
     * @return User
     */
    public function recipiente()
    {
        return $this->belongsTo(User::class,'recipiente_id');
    }
    
}
