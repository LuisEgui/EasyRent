
<?php
//Inicio del procesamiento
session_start();

function getVehiculos($model = null, $fuelType = null, $seatCount = null, $state = null)
    {
        $númargs = func_num_args();
        echo "Número de argumentos: $númargs\n";
    }

    
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

$contenidoPrincipal .= getVehiculos(null, 4, 5, null);

include 'includes/vistas/plantillas/plantilla.php';