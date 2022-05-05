<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioCancelarReserva.php';
require_once __DIR__.'/includes/FormularioActualizarReturnLocationReserva.php';
require_once __DIR__.'/includes/FormularioActualizarPickupTimeReserva.php';
require_once __DIR__.'/includes/FormularioActualizarReturnTimeReserva.php';
require_once __DIR__.'/includes/FormularioActualizarVehiculoReserva.php';
require_once __DIR__.'/includes/FormularioActualizarPrecioReserva.php';

$returnLocationForm = new FormularioActualizarReturnLocationReserva();
$htmlFormReturnLocation = $returnLocationForm->gestiona();
$pickupTimeForm = new FormularioActualizarPickupTimeReserva();
$htmlFormPickupTime = $pickupTimeForm->gestiona();
$returnTimeForm = new FormularioActualizarReturnTimeReserva();
$htmlFormReturnTime = $returnTimeForm->gestiona();

$vehicleForm = new FormularioActualizarVehiculoReserva();
$htmlFormVehicle = $vehicleForm->gestiona();
$priceForm = new FormularioActualizarPrecioReserva();
$htmlFormPrice = $priceForm->gestiona();

$deleteForm = new FormularioCancelarReserva();
$htmlDeleteForm = $deleteForm->gestiona();

$tituloPagina = 'Gestionar reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Gestionar reserva de vehiculo</h1>
<h3>Modificar localizacion de devolucion</h3>
$htmlFormReturnLocation
<h3>Modificar hora de recogida</h3>
$htmlFormPickupTime
<h3>Modificar hora de devolucion</h3>
$htmlFormReturnTime
<h3>Modificar coche reservado</h3>
$htmlFormVehicle
<h3>Modificar coche reservado</h3>
$htmlFormPrice
<h3>Cacelar reserva</h3>
$htmlDeleteForm
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';