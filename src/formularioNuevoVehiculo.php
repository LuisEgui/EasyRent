<?php
//Inicio del procesamiento
session_start();

$tituloPagina = 'Crear Vehiculo';
$contenidoPrincipal = <<< EOS
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
        <input type="text" id="mod" name="model"/>
    </div>
    <div>
        <label for="fuelT">Fuel Type: </label>
        <select id="fuelT" name="fuelType">
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
        <select id="state" name="state">
            <option value="available" selected>Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="reserved">Reserved</option>
        </select>
    </div>
    <div>
        <input type="submit" name="enviar" value="Crear vehiculo">
    </div>
</form>
EOS;

include 'includes/vistas/plantillas/plantilla.php';