<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use App\Models\Anuncio;
use App\Models\Foto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserAnuncioOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // no tiene index
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user_id = Auth::user()->id;
        $tipoAnunc = 'oferta';
        return view('user.anuncCreateOferta', ['user' => $id, 'tipoAnunc' => $tipoAnunc]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->name; //nombre del usuario
        $user_id = Auth::user()->id; //id del usuario
        //validar entrada del request
        $entrada = $request->validate(
            [
                'titulo' => 'required|min:10|max:100',
                'descripcion' => 'required|min:10|max:300',
                'raza' => 'required|not_regex:/^todo$/',
                'genero' => 'required|not_regex:/^todo$/',
                'fecha_nac' => 'required|date',
                'comunidad' => 'required|not_regex:/^todo$/',
                'provincia' => 'required|not_regex:/^todo$/',
                'poblacion' => 'required|not_regex:/^todo$/',
                'lat' => 'required',
                'lon' => 'required',
                'foto1' => 'required|image',
                'foto2' => 'image',
                'foto3' => 'image',
                'foto4' => 'image',
                'foto5' => 'image'
            ]
        );
        $entrada['id_usuario'] = $user_id;
        $entrada['estado'] = 'active';
        $entrada['tipo'] = 'oferta';
        Anuncio::create($entrada); // insertar anuncio en la tabla 'anuncios'
        $ult_anuncio = DB::table('anuncios')->latest()->first();
            $entrada['id'] = $ult_anuncio->id;
      
        AnuncioOferta::create($entrada); // insertar anuncio en la tabla 'anuncios'
            
        


        // ultimo anuncio del user (anuncio actual)
        // $ult_anuncio = DB::table('anuncios')->where('id_usuario', $user_id)->latest()->first();


        //guardar fotos del formulario para ordenar si por acaso no existen algunos fotos por el medio
        $fotos_user = array();
        for ($i = 1; $i <= 5; $i++) {
            $string = 'foto' . $i;
            if ($request->file($string)) {
                $fotos_user[] = $request->file($string);
            }
        }

        foreach ($fotos_user as $key => $foto) {
            //guardo ficheros validados en servidor 
            $fichero = $this->cargarFichero($foto, $user_id, $entrada['id'], 'foto' . $key);
            //insert to database - tabla "fotos"
            Foto::create($fichero);
        }
        // insert to database - tabla "anuncios_oferta"
        //  AnuncioOferta::create($fichero);



        // NO TERMINADO



        $usersDemandas = AnuncioDemanda::where('id_usuario', $user_id)->get();
        $usersOfertas = AnuncioOferta::where('id_usuario', $user_id)->get();
        return Redirect::route('user.anuncios.index', ['user' => $user, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * cargar fichero con nombre cambiado
     * 
     * Cambiar nombre del archivo en formato <id_anuncio>-<id_user>-<foto>.<extencion>
     * y guardar fotos validos 
     * en servidor carpeta /storage/app/usersImages
     * 
     * @param File $miFichero
     * @param int $user_id
     * @param int $id_anuncio
     * @param string $nombre = 'foto1', 'foto2' ...
     * @return array
     */
    public function cargarFichero($miFichero, $user_id, $id_anuncio, $nombre)
    {
        // Obtener nombre originale del fichero
        $original_file_name = $miFichero->getClientOriginalName();

        // Obtener extension del fichero
        $file_extension = $miFichero->getClientOriginalExtension();

        // Crear nombre nuevo para fichero
        $new_file_name = $id_anuncio . '-' . $user_id . '-' . $nombre . '.' . $file_extension;

        // guardar archivo en servidor carpeta /storage/app/usersImages
        $miFichero->storeAs('/usersImages', $new_file_name, 'public');

        // Obtener URL del fichero
    
       $file_url = Storage::disk('public')->url($new_file_name);
       
        $entrada = ['nombre_originale' => $original_file_name, 'enlace' => $file_url, 'id_anuncio' => $id_anuncio];
        return $entrada;
    }
}
