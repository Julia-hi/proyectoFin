<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use App\Models\Anuncio;
use App\Models\AnuncioOferta;
use App\Models\AnuncioDemanda;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'rol',
        'estado'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard = 'admin';


    function isAdmin()
    {
        if (Auth::user()->rol == "admin") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get anuncios del usuario
     */
    public function anuncios()
    {
        return $this->hasMany(Anuncio::class);
    }

    /**
     * Get anuncios oferta del usuario
     */
    public function anunciosOferta()
    {
        return $this->hasMany(AnuncioOferta::class, 'user_id');
    }

    /**
     * Get anuncios oferta del usuario
     */
    public function anunciosDemanda()
    {
        return $this->hasMany(AnuncioDemanda::class);
    }

    /**
     * Get mensaje del usuario
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'user_id');
    }

    /**
     * Get favoritos
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function esAutor(User $user)
    {  
        return $this->anuncios()->where('user_id', $user->id)->exists();
    }
}
