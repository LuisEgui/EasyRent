<?php

require_once __DIR__.'\includes\config.php';
require_once __DIR__.'\includes\FormularioReserva.php';
require_once __DIR__.'\includes\Reserva.php';


$tituloPagina = 'Lista reservas';
$reservas = Reserve::reservasPersonales();
$contenidoPrincipal = <<<EOS
<h1>Lista reservas</h1>
EOS;
for ($i = 0; $i < count($reservas); $i++) {
    //hacer algo para que vehiculos reservados no salgan
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
        </div>
    EOS;
    
    
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';