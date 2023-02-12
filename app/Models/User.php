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
     * Get anuncio del usuario
     */
    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class);
    }

    /**
     * Get mensaje del usuario
     */
    public function mensaje()
    {
        return $this->hasMany(Mensaje::class);
    }
}
