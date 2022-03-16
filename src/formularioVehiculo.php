<?php 

$formulario = <<< DELIM
<form>
    <div>
        <label for="nombreNowdoc">Nombre: </label>
        <input type="text" id="nombreNowdoc" name="nombre" value="$nombre" />
    </div>
    <div>
        <label for="apellidoNowedoc">Apellido: </label>
        <input type="text" id="apellidoNowedoc" name="apellido" value="$apellido" />
    </div>
</form>
DELIM;