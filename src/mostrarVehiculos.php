<?php


require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\persistance\entity\Vehicle;
use easyrent\includes\service\VehicleService;
use easyrent\includes\service\ReserveService;

$vehicleService = VehicleService::getInstance();
$reserveService = ReserveService::getInstance();
$modelService = ModelService::getInstance();

$location = $_GET['location'];
$vehiculos = $vehicleService->readAllVehiclesInLocation($location);

$tituloPagina = 'Lista vehiculos';

$contenidoPrincipal = <<<EOS
<h1>Lista vehiculos</h1>
EOS;
if (count($vehiculos) === 0) {
    $contenidoPrincipal .= <<<EOS
    <h3>No hay vehiculos en la localizacion elegida</h3>
    EOS;
}
else{
    $pickupDate = null;
    $returnDate = null;

    if(isset($_GET['pDate'])){
        $pickupDate = $_GET['pDate'];
    }
    if(isset($_GET['rDate'])){
        $returnDate = $_GET['rDate'];
    }
    for ($i = 0; $i < count($vehiculos); $i++) { 
        if(!$reserveService->findIfExistingReserve($vehiculos[$i]->getVin(), $pickupDate, $returnDate)) {
            array_splice($vehiculos, $i, 1);
            $i--;
        }
    }
    if (count($vehiculos) === 0) {
        $contenidoPrincipal .= <<<EOS
        <h3>Hay vehiculos en la localizacion elegida pero no en las fechas seleccionadas</h3>
        EOS;
    }
}


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
        Submodel:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getSubmodel();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Location: 
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getLocation();
    $contenidoPrincipal .= <<<EOS
        </p>        
        <p>
        Fuel type:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getFuelType();
    $contenidoPrincipal .= <<<EOS
        </p>
        Seat count:
    EOS;
    $contenidoPrincipal .= $vehicleModel->getSeatCount();
    $contenidoPrincipal .= <<<EOS
        </p>
    EOS;
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $contenidoPrincipal .= <<<EOS
        <h4>TARIFA</h4>
        <h4>20€</h4>
        <a href="reserva.php?id=
    EOS;
        $contenidoPrincipal .= $vehiculos[$i]->getVin();
        $contenidoPrincipal .= <<<EOS
        &location=
    EOS;
        $contenidoPrincipal .= $vehiculos[$i]->getLocation();
        $contenidoPrincipal .= <<<EOS
        ">Reservar</a> 
        </div>
    EOS;
    }
    else{
        $contenidoPrincipal .= <<<EOS
        <h4>TARIFA</h4>
        <h4>20€</h4>
        <p>[Para reservar inicie sesión]</p>
        </div>
    EOS;
    }

}
require __DIR__.'/includes/vistas/plantillas/plantilla.php';
