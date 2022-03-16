
<?php
//Inicio del procesamiento
session_start();

$tituloPagina = 'Formulario Vehiculo';
$contenidoPrincipal = <<< EOS
<form>
    <div>
        <label for="nombreNowdoc">Nombre: </label>
        <input type="text" id="nombreNowdoc" name="nombre" value="nombre" />
    </div>
    <div>
        <label for="apellidoNowedoc">Apellido: </label>
        <input type="text" id="apellidoNowedoc" name="apellido" value="apellido" />
    </div>
</form>
EOS;

include 'includes/vistas/plantillas/plantilla.php';