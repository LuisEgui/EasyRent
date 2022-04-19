<?php

require_once __DIR__.'\includes\config.php';
require_once __DIR__.'\includes\FormularioVehiculo.php';
require_once __DIR__.'\includes\Vehiculo.php';

//$form = new FormularioVehiculo();
//$htmlFormVehiculo = $form->gestiona();

$tituloPagina = 'Lista vehiculos';
$vehiculos = Vehiculo::buscaPorFiltros();
$contenidoPrincipal = <<<EOS
<h1>Listar vehiculos</h1>
EOS;
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
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $contenidoPrincipal .= <<<EOS
        </p>
        <h4>TARIFA</h4>
        <h4>20€</h4>
        <a href="reserva.php?id=
    EOS;
        $contenidoPrincipal .= $vehiculos[$i]->getVin();
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