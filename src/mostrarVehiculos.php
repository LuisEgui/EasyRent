<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Vehicle.php';
require_once __DIR__.'/includes/VehicleService.php';
require_once __DIR__.'/includes/ReserveService.php';

$vehicleService = VehicleService::getInstance();
$reserveService = ReserveService::getInstance();

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
    //hacer algo para que vehiculos reservados no salgan
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
        Location:  
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getLocation();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        State: 
    EOS;
    $contenidoPrincipal .= $vehiculos[$i]->getState();
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $contenidoPrincipal .= <<<EOS
        </p>
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
        </p>
        <h4>TARIFA</h4>
        <h4>20€</h4>
        <p>[Para reservar inicie sesión]</p>
    EOS;
    }
    
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';