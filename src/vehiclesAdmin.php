<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\VehicleService;
use easyrent\includes\service\ModelService;
use easyrent\includes\service\lists\VehicleList;

$vehicleService = VehicleService::getInstance();
$modelService = ModelService::getInstance();

$defaultFunctions = array('cmpVin', 'cmpLicensePlate', 'cmpBrand', 'cmpModel', 'cmpCategory', 'cmpGearbox', 'cmpFuelType', 'cmpSeatCount', 'cmpLocation', 'cmpState', 'cmpFecha');
$functionNames = ['cmpVin' => 'VIN', 'cmpLicensePlate' => 'Matricula', 'cmpBrand' => 'Marca', 'cmpModel' => 'Modelo', 'cmpCategory' => 'Categoria', 'cmpGearbox' => 'Caja de cambios', 'cmpFuelType' => 'Tipor de combustible', 'cmpSeatCount' => 'Numero de asientos', 'cmpLocation' => 'Ubicacion', 'cmpState' => 'Estado', 'cmpFecha' => 'Fecha de modificacion'];


$vehiclesList = new VehicleList($vehicleService->readAllVehicles());

if(isset($_GET['orderVehiclesBy']) && in_array($_GET['orderVehiclesBy'], $defaultFunctions)){
    $vehiclesList->orderBy($_GET['orderVehiclesBy']);
}

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/vehiclesAdmin.php?orderVehiclesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Administrar vehículos';

$contenidoPrincipal = <<<EOS
    <div>
    <h2>Lista de vehiculos</h2>
    <div class="dropdown">
    <button class="dropbtn" style="float:left">Filtros</button>
    <div class="dropdown-content">
    $filterSelector
    </div>
    </div>
    <div>
    <table>
        <tr>
            <th>VIN</th>
            <th>Matricula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Submodelo</th>
            <th>Categoria</th>
            <th>Caja de cambios</th>
            <th>Tipo de combustible</th>
            <th>Numero de asientos</th>
            <th>Ubicacion</th>
            <th>Estado</th>
            <th>Fecha de modificacion</th>
        </tr>
EOS;
foreach($vehiclesList->getArray() as $vehicle) {
    $vehicleModel = $modelService->readModelById($vehicle->getModel());
    $contenidoPrincipal .= <<<EOS
        <tr>
            <td>{$vehicle->getVin()}</td>
            <td>{$vehicle->getLicensePlate()}</td>
            <td>{$vehicleModel->getBrand()}</td>
            <td>{$vehicleModel->getModel()}</td>
            <td>{$vehicleModel->getSubmodel()}</td>
            <td>{$vehicleModel->getCategory()}</td>
            <td>{$vehicleModel->getGearbox()}</td>
            <td>{$vehicleModel->getFuelType()}</td>
            <td>{$vehicleModel->getSeatCount()}</td>
            <td>{$vehicle->getLocation()}</td>
            <td>{$vehicle->getState()}</td>
            <td>{$vehicle->getTimeStamp()}</td>
        </tr>
    EOS;
}
$contenidoPrincipal .= <<<EOS
    </table>
    </div>
    </div>
    <div>
    <div class="info">
    <a href="nuevoVehiculo.php">Añadir vehiculo</a>
    </div>
    <div class="info">
    <a href="borrarVehiculo.php">Borrar vehiculo</a>
    </div>
    <div class="info">
    <a href="actualizarVehiculo.php">Actualizar vehiculo</a>
    </div>
    <div id="anteriorUrl">
    <a href="admin.php">Atrás</a>
    </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
