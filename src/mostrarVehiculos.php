<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\VehicleService;
use easyrent\includes\service\ModelService;

$tituloPagina = 'Lista vehiculos';
$vehicleService = VehicleService::getInstance();
$modelService = ModelService::getInstance();
$vehiculos = $vehicleService->readAllVehicles();
$contenidoPrincipal = <<<EOS
<h1>Listar vehiculos</h1>
EOS;
for ($i = 0; $i < count($vehiculos); $i++) {
    $vehicleModel = $modelService->readModelById($vehiculos[$i]->getModel());
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
        Marca:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getBrand();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Model:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getModel();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Fuel type:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getFuelType();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Seat count:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getSeatCount();
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
