<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnuncioOferta extends Model
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
        'lat',
        'lon',
        'id_usuario'
    ];
}
