<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\VehicleService;

$tituloPagina = 'Lista vehiculos';
$vehicleService = VehicleService::getInstance();
$vehiculos = $vehicleService->readAllVehicles();
$contenidoPrincipal = <<<EOS
<h1>Listar vehiculos</h1>
EOS;
for ($i = 0; $i < count($vehiculos); $i++) {
    $contenidoPrincipal .= <<<EOS
    <div class="v">
        <h2>Vehiculo
    EOS;
    $contenidoPrincipal .= $i + 1;
    $contenidoPrincipal .= <<<EOS
        </h2>
        <p>
        Vin:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getVin();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        License plate:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getLicensePlate();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Model:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getModel();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Fuel type:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getFuelType();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Seat count:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getSeatCount();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        State:
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getState();
    $contenidoPrincipal .= <<<EOS
        </p>
        <h4>TARIFA</h4>
        <h4>20€</h4>
        <a href="index.php">Reservar</a>
    </div>
    EOS;

}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
