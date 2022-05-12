<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarDatosVehiculo;

$vinToUpdate = null;

if(isset($_GET['vinVehicleToUpdate'])){
    $vinToUpdate = $_GET['vinVehicleToUpdate'];
}

$form = new FormularioActualizarDatosVehiculo($vinToUpdate);

$htmlFormUpdateVehicleData = $form->gestiona();

$tituloPagina = 'Actualizar Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Actualizar Vehiculo</h1>
$htmlFormUpdateVehicleData
<div id="anteriorUrl">
    <a href="vehiclesAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
