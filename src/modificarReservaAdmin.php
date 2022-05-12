<?php

use easyrent\includes\forms\FormularioActualizarPickupTimeReserva;
use easyrent\includes\forms\FormularioActualizarPrecioReserva;
use easyrent\includes\forms\FormularioActualizarReturnLocationReserva;
use easyrent\includes\forms\FormularioActualizarReturnTimeReserva;
use easyrent\includes\forms\FormularioActualizarVehiculoReserva;
use easyrent\includes\forms\FormularioCancelarReserva;

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

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
<div id="anteriorUrl">
    <a href="reservasAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
