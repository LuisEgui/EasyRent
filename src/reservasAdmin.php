<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Reserve.php';
require_once __DIR__.'/includes/MysqlReserveRepository.php';
require_once __DIR__.'/includes/ReserveService.php';

$reserveService = new ReserveService($GLOBALS['db_reserve_repository'], $GLOBALS['db_vehicle_repository'], $GLOBALS['db_user_repository']);
$tituloPagina = 'Lista reservas';

$reservas = $reserveService->getAllReserves();
$contenidoPrincipal = <<<EOS
<h1>Lista reservas</h1>
EOS;
for ($i = 0; $i < count($reservas); $i++) {
    $contenidoPrincipal .= <<<EOS
    <div class="v">
        <h2>Reserva 
    EOS;
    $contenidoPrincipal .= $i + 1;
    $contenidoPrincipal .= <<<EOS
        </h2>
        <p>
        Vin: 
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getVehicle();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Estado: 
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getState();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Localización de recogida: 
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getPickUpLocation();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Localización de devolución:  
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getReturnLocation();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Hora recogida: 
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getPickUpTime();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Hora devolución: 
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getReturnTime();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Precio:
    EOS;
    $contenidoPrincipal .= $reservas[$i]->getPrice();
    $contenidoPrincipal .= <<<EOS
        <p>
        <a href="modificarReservaAdmin.php?id=
    EOS;
        $contenidoPrincipal .= $reservas[$i]->getId();
        $contenidoPrincipal .= <<<EOS
        ">Modificar</a> 
        </div>
    EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';