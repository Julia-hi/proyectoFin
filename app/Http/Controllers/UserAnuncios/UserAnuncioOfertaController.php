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

class UserAnuncioOfertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (Auth::user()->rol == "admin") {
            return redirect()->route('admin');
        } else {
        $tipoAnunc = 'oferta';
        return view('user.anuncCreateOferta', ['user' => $id, 'tipoAnunc' => $tipoAnunc]);}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        //validar entrada del request
        $entrada = $request->validate(
            [
                'titulo' => 'required|min:5|max:30',
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
        $entrada['user_id'] = $user->id;
        $entrada['estado'] = 'active';
        $entrada['tipo'] = 'oferta';
        Anuncio::create($entrada); // insertar anuncio en la tabla 'anuncios'
        $ult_anuncio = DB::table('anuncios')->latest()->first();
        $entrada['id'] = $ult_anuncio->id;

        AnuncioOferta::create($entrada); // insert to database - tabla "anuncios_oferta"

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
            $fichero = $this->cargarFichero($foto, $user->id, $entrada['id'], 'foto' . $key);
            Foto::create($fichero); //insert to database - tabla "fotos"
        }
        $usersDemandas = AnuncioDemanda::where('user_id', $user->id)->get();
        $usersOfertas = AnuncioOferta::where('user_id', $user->id)->get();
        return Redirect::route('user.anuncios.index', ['user' => $user->name, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => 'ok']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $id_anuncio)
    {
        $anuncio = AnuncioOferta::find($id_anuncio);
        return view('user.anuncEditOferta', ['user' => Auth::user()->id, 'anuncios_ofertum' => $id, 'anuncio' => $anuncio]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_anuncio)
    {
        $oferta = AnuncioOferta::findOrFail($id_anuncio);
        $fotos = $oferta->fotos();
        $rules =
            [
                'titulo' => 'required|min:5|max:30',
                'descripcion' => 'required|min:10|max:300',
                'raza' => 'required|not_regex:/^todo$/',
                'genero' => 'required|not_regex:/^todo$/',
                'fecha_nac' => 'required|date',
                'comunidad' => 'required|not_regex:/^todo$/',
                'provincia' => 'required|not_regex:/^todo$/',
                'poblacion' => 'required|not_regex:/^todo$/',
                'lat' => 'required',
                'lon' => 'required'
            ];
        if ($oferta->titulo === $request->titulo) {
            $rules['titulo'] = 'sometimes';
        }
        if ($oferta->descripcion === $request->descripcion) {
            $rules['descripcion'] = 'sometimes';
        }
        if ($oferta->raza === $request->raza) {
            $rules['raza'] = 'sometimes';
        }
        if ($oferta->genero === $request->genero) {
            $rules['genero'] = 'sometimes';
        }
        if ($oferta->fecha_nac === $request->fecha_nac) {
            $rules['fecha_nac'] = 'sometimes';
        }
        if ($oferta->comunidad === $request->comunidad) {
            $rules['comunidad'] = 'sometimes';
        }
        if ($oferta->provincia === $request->provincia) {
            $rules['provincia'] = 'sometimes';
        }
        if ($oferta->poblacion === $request->poblacion) {
            $rules['poblacion'] = 'sometimes';
        }
        if ($oferta->lat === $request->lat) {
            $rules['lat'] = 'sometimes';
        }
        if ($oferta->lon === $request->lon) {
            $rules['lon'] = 'sometimes';
        }

        $oferta->titulo = $request->titulo;
        $oferta->descripcion = $request->descripcion;
        $oferta->raza = $request->raza;
        $oferta->genero = $request->genero;
        $oferta->fecha_nac = $request->fecha_nac;
        $oferta->comunidad = $request->comunidad;
        $oferta->provincia = $request->provincia;
        $oferta->poblacion = $request->poblacion;
        $oferta->lat = $request->lat;
        $oferta->lon = $request->lon;
        $oferta->save();
        return Redirect::route('user.anuncios.index', ['user' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $id_anuncio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_anuncio)
    {
        $anuncio = Anuncio::find($id_anuncio);
        //obtener todos fotos pertenecentes a anuncio
        $fotos = AnuncioOferta::find($id_anuncio)->fotos()->get();
        //eliminate ficheros desde storage
        foreach ($fotos as $foto) {
            $fileToDelete = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . $foto->enlace);
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }
        $anuncio->delete();
        return Redirect::route('user.anuncios.index', ['user' => $id]);
    }

    /**
     * cargar fichero con nombre cambiado
     * 
     * Cambiar nombre del archivo en formato <anuncio_id>-<user_id>-<foto>.<extencion>
     * y guardar fotos validos 
     * en servidor carpeta /storage/app/usersImages
     * 
     * @param File $miFichero
     * @param int $user->id
     * @param int $anuncio_id
     * @param string $nombre = 'foto1', 'foto2' ...
     * @return array
     */
    public function cargarFichero($miFichero, $user_id, $anuncio_id, $nombre)
    {
        // Obtener nombre originale del fichero
        $original_file_name = $miFichero->getClientOriginalName();

        // Obtener extension del fichero
        $file_extension = $miFichero->getClientOriginalExtension();

        // Crear nombre nuevo para fichero
        $new_file_name = $anuncio_id . '-' . $user_id . '-' . $nombre . '.' . $file_extension;

        // guardar archivo en servidor carpeta /storage/app/usersImages
        $miFichero->move(public_path('/storage/usersImages'), $new_file_name);

        // Obtener URL del fichero guardado
        $file_url = "/storage/usersImages/" . $new_file_name;
        $entrada = ['nombre_originale' => $original_file_name, 'enlace' => $file_url, 'anuncio_id' => $anuncio_id];
        return $entrada;
    }
}
