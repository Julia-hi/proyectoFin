<?php

?>
<x-app-layout>
    <h2>Modifica tu anuncio</h2>
    <div>
<?php
if(isset($anuncio)){
    echo("update anuncio con id:".$anuncio);
    // formulario para undate
}else{
    echo("id required.");
}
?>
</div>
</x-app-layout>