<?php
session_start();

// use ClaseVehiculo; solo cuando están en distintos directorios??

$tituloPagina = 'Validación Nuevo Vehiculo';

// 1. Validación sintáctica.
$vin = $_POST['vin'] ?? null;
$licensePlate = $_POST['licensePlate'] ?? null;
$model = $_POST['model'] ?? null;
$model = $_POST['fuelType'] ?? null;
$model = $_POST['seatCount'] ?? null;
$model = $_POST['state'] ?? null;

// 2. Validación semántica.
$esValido = true;

// 2.1 Validación del parámetro $nombre según las reglas de la aplicación
$esValido = $esValido && is_numeric($vin);

// 2.2 Validación del parámetro $apellido según las reglas de la aplicación
$esValido = $esValido && mb_strlen($licensePlate) >= 6;

// 2.3 Validación del campo numérico
$esValido = $esValido && is_numeric($model); //&& intval($model) >= 12

//$esValido = && $vin != null

//$esValido = $esValido && is_numeric($fuelType); no es necesario validar un <select> no?

//$esValido = $esValido && is_numeric($seatCount) && intval($model) >= 2;

//$esValido = $esValido && is_numeric($state);

/* 3. Implementar la lógica asociada a la petición y a los datos validados.
 * Normalmente se hace algo más interesante que mostrar un mensaje, por ejemplo, modificar la BD, etc.
 */

$validacion = $esValido ? 'El formulario es válido' : 'El formulario NO es valido';

$htmlForm=<<<EOF
<p>Validación: $validacion</p>
<form action="procesarNuevoVehiculo.php" method="POST">
    <div>
        <label for="vin">Vehicle Identification Number: </label>
        <input type="text" id="vin" name="vin" />
    </div>
    <div>
        <label for="licPl">License Plate: </label>
        <input type="text" id="licPl" name="licensePlate" />
    </div>
    <div>
        <label for="mod">Model: </label>
        <input type="text" id="mod" name="model" />
    </div>
    <div>
        <label for="fuelT">Fuel Type: </label>
        <select name="lenguajes">
            <option value="diesel">Diesel</option>
            <option value="electric-hybrid">Electric-hybrid</option>
            <option value="electric">Electric</option>
            <option value="petrol">Petrol</option>
            <option value="plug-in-hybrid">Plug-in-hybrid</option>
        </select>
    </div>
    <div>
        <label for="seatC">Seat Count: </label>
        <input type="number" id="seatC" name="seatCount" value="5" min="2" max="9" />
    </div>
    <div>
        <label for="state">State: </label>
        <select name="lenguajes">
            <option value="available" selected>Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="reserved">Reserved</option>
        </select>
    </div>
    <div>
        <input type="submit" name="enviar" value="Crear vehiculo">
    </div>
</form>
EOF;

if (! $esValido ) {
    $contenidoPrincipal = $htmlForm;
} else {
    $contenidoPrincipal=<<< EOS
        <p>Validación: $validacion </p>
    EOS;
}

include 'includes/vistas/plantillas/plantilla.php';
