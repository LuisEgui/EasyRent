<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Vehicle.php';
require_once __DIR__.'/includes/VehicleService.php';

$vehicleService = new VehicleService($GLOBALS['db_vehicle_repository'], $GLOBALS['db_image_repository']);

$tituloPagina = 'Lista vehiculos';

$vehicles = $vehicleService->readAllVehicles();

$contenidoPrincipal = <<<EOS
        <h1>Lista de vehiculos</h1>
        <table>
            <tr>
                <th>VIN</th>
                <th>Matricula</th>
                <th>Modelo</th>
                <th>Tipo de combustible</th>
                <th>Numero de asientos</th>
                <th>Estado</th>
            </tr>
    EOS;

    foreach($vehicles as $vehicle) {
        $contenidoPrincipal .= <<<EOS
            <tr>
                <td>{$vehicle->getVin()}</td>
                <td>{$vehicle->getLicensePlate()}</td>
                <td>{$vehicle->getModel()}</td>
                <td>{$vehicle->getFuelType()}</td>
                <td>{$vehicle->getSeatCount()}</td>
                <td>{$vehicle->getState()}</td>
            </tr>
        EOS;
    }
    $contenidoPrincipal .= <<<EOS
        </table>
    EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';