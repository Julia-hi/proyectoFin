<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Municipio extends Model
{
    use HasFactory;
 /**
  * @var string $patch - location of json file
  */
  private $patch;

  /**
  * @var array $arrayFromJson
  */
  private $arrayFromJson;

    function __construct(){
        $this->patch = Storage::url('listadoMunicipiosEspana.json');
        $this->arrayFromJson = json_decode($this->patch, true);
    }

    function getArrayFromJson(){
        return $this->arrayFromJson;
    }
    
}
