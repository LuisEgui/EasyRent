<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\ReserveService;

$reserveService = ReserveService::getInstance();
$tituloPagina = 'Lista reservas';

$reservas = $reserveService->getAllPersonalReserves();
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
        Matricula:
    EOS;
    $vin = $reservas[$i]->getVehicle();
    $contenidoPrincipal .= $reserveService->getLicensePlate($vin);
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
    if($reservas[$i]->getState() === 'reserved') {
        $contenidoPrincipal .= <<<EOS
        </p>
        <p> Reserva Confimada </p>
        </div>
    EOS;
    }
    else {
        $contenidoPrincipal .= <<<EOS
        </p>
        <a href="modificarReserva.php?id=
    EOS;
        $contenidoPrincipal .= $reservas[$i]->getId();
        $contenidoPrincipal .= <<<EOS
        ">Modificar</a>
        <a href="confirmarReserva.php?id=
    EOS;
        $contenidoPrincipal .= $reservas[$i]->getId();
        $contenidoPrincipal .= <<<EOS
        ">Confirmar reserva</a>
        </div>
    EOS;
    }

}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
