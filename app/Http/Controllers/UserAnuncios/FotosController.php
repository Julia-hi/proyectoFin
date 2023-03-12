<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Foto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class FotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $ofertum)
    {
        $fotos = $request->allFiles();

        foreach ($fotos as $key => $foto) {
            $filename = $foto->getClientOriginalName();
            echo ($key);
            $fichero = $this->cargarFichero($foto, Auth::user()->id, $ofertum, $key);
            Foto::create($fichero); //insert to database - tabla "fotos"
        }
        return redirect()->back();
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
     * @param  int  $foto - id de foto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $anuncio_id, $foto)
    {
        $request->validate([
            'foto0' => 'image',
            'foto1' => 'image',
            'foto2' => 'image',
            'foto3' => 'image',
            'foto4' => 'image',
        ]);
        $foto_sustituir = Foto::find($foto);

        $fileToUpdate = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . $foto_sustituir->enlace);

        if (file_exists($fileToUpdate)) {
            //obtener value of atributo "name" de input
            $key = preg_match('/foto(\d+)/', $fileToUpdate, $matches);

            $nuevoFotoInput = $request->file($matches[0]);
            unlink($fileToUpdate);
            $fichero = $this->cargarFichero($nuevoFotoInput, Auth::user()->id, $anuncio_id, $matches[0]);
            $foto_sustituir->nombre_originale = $fichero['nombre_originale'];
            $foto_sustituir->enlace = $fichero['enlace'];
            $foto_sustituir->save();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $foto - foto id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ofertum, $foto)
    {
        $foto_eliminar = Foto::find($foto);

        $fileToDelete = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . $foto_eliminar->enlace);
        if (file_exists($fileToDelete)) {
            unlink($fileToDelete);
        }
        $foto_eliminar->delete();
        $fotos = Foto::where('anuncio_id', $ofertum)->get();
        for ($i = 0; $i < $fotos->count(); $i++) {
            $enlace = $fotos[$i]->enlace;
            $foto_id = $fotos[$i]->id;
            $fileToUpdate = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . $enlace);
            //obtener string de enlace 'file0' - 'file1' - ... - 'file4'
            $key = preg_match('/foto(\d+)/', $fileToUpdate, $matches);
            // modificar enlace en database y cambiar nombre del archivo para eliminar huecos 
            // ordener fotos  cuando usuario elimina una foto del medio
            if ($matches[0] != $i) {
                $nuevaEnlace = str_replace($matches[0], 'foto' . $i, $enlace);
                $nuevoFile = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . $nuevaEnlace);
                $fotoParaModificar = Foto::find($foto_id);
                $fotoParaModificar->enlace = $nuevaEnlace;
                $fotoParaModificar->save(); //modificar foto en la base de datos
                if (file_exists($fileToUpdate)) {
                    rename($fileToUpdate, $nuevoFile);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * cargar fichero con nombre cambiado
     * 
     * Cambiar nombre del archivo en formato <anuncio_id>-<user_id>-<'foto'><numero>.<extencion>
     * y guardar fotos 
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
