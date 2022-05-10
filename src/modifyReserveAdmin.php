<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioModificarReserva.php';

$defaultFunctions = array('cmpId', 'cmpVIN', 'cmpUser', 'cmpPickupLocation', 'cmpReturnLocation', 'cmpPickupDate', 'cmpReturnDate', 'cmpPrice', 'cmpState');
$functionNames = ['cmpId' => 'ID Reserva', 'cmpVIN' => 'VIN Vehiculo', 'cmpUser' => 'ID Usuario', 'cmpPickupLocation' => 'Ubicacion recogida', 'cmpReturnLocation' => 'Ubicacion devolucion', 'cmpPickupDate' => 'Fecha recogida', 'cmpReturnDate' => 'Fecha devolucion', 'cmpPrice' => 'Precio', 'cmpState' => 'Estado'];

$orderByFunction = null;

if(isset($_GET['orderReservesBy']) && in_array($_GET['orderReservesBy'], $defaultFunctions)){
    $orderByFunction = $_GET['orderReservesBy'];
}

$form = new FormularioModificarReserva($orderByFunction);

$htmlFormUpdateReserve = $form->gestiona();

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/modifyReserveAdmin.php?orderVehiclesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Actualizar Reserva';

$contenidoPrincipal = <<<EOS
<h1>Actualizar Reserva</h1>
<div class="dropdown">
<button class="dropbtn" style="float:left">Filtros</button>
<div class="dropdown-content">
$filterSelector
</div>
</div>
$htmlFormUpdateReserve
<div id="anteriorUrl">
    <a href="reservasAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
