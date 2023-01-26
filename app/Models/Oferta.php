<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'rasa',
        'genero',
        'fecha_nac',
        'com_autonoma',
        'provincia',
        'localidad',
        'calle',
        'id_usuario'
    ];

}
