<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioEliminarVehiculo;

$defaultFunctions = array('cmpVin', 'cmpLicensePlate', 'cmpBrand', 'cmpModel', 'cmpLocation', 'cmpState', 'cmpFecha');
$functionNames = ['cmpVin' => 'VIN', 'cmpLicensePlate' => 'Matricula', 'cmpBrand' => 'Marca', 'cmpModel' => 'Modelo', 'cmpLocation' => 'Ubicacion', 'cmpState' => 'Estado', 'cmpFecha' => 'Fecha de modificacion'];

$orderByFunction = null;

if(isset($_GET['orderVehiclesBy']) && in_array($_GET['orderVehiclesBy'], $defaultFunctions)){
    $orderByFunction = $_GET['orderVehiclesBy'];
}

$form = new FormularioEliminarVehiculo($orderByFunction);

$htmlFormDeleteVehicle = $form->gestiona();

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/borrarVehiculo.php?orderVehiclesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Eliminar Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Eliminar Vehiculo</h1>
<div class="dropdown">
<button class="dropbtn" style="float:left">Filtros</button>
<div class="dropdown-content">
$filterSelector
</div>
</div>
$htmlFormDeleteVehicle
<div id="anteriorUrl">
    <a href="vehiclesAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
