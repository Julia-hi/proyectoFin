<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Foto;
use App\Models\Anuncio;
use App\Models\User;
use App\Models\Favorito;
use Illuminate\Support\Facades\DB;

class AnuncioOferta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anuncios_oferta';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'raza',
        'genero',
        'fecha_nac',
        'comunidad',
        'provincia',
        'poblacion',
        'lat',
        'lon',
        'user_id',
        'created_at'
    ];

    /**
     * Obtener anuncio
     * @return Anuncio
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class,'anuncio_id');
    }

    function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * favoritos a que pertenece anuncio concreto
     * @return Object
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'anuncio_id');
    }

    /**
     * Relacion uno/uno
     * @return Foto
     */
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'anuncio_id');
    }


    /**
     * @param int $id_user
     * @param int $id_anuncio
     * @return AnuncioOferta
     */
   /*  public function esFavorito($id_user, $id_anuncio)
    {
       
        $favorito= DB::table('favoritos')->where('id_usuario', $id_user)->where('id_anuncio', $id_anuncio)->get();
        if($favorito->count()>0){
           // $anuncio = DB::table('anuncios_oferta')->where('id', $id_anuncio)->get();
            return $favorito;
        }else{
            return null;
        }
    } */


    public function esFavorito(User $user, AnuncioOferta $anuncio)
    {
        return $user->favoritos()->where('anuncio_id', $anuncio->id)->exists();
    }
}
