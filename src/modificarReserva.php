<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarPickupTimeReserva;
use easyrent\includes\forms\FormularioActualizarReturnLocationReserva;
use easyrent\includes\forms\FormularioActualizarReturnTimeReserva;
use easyrent\includes\forms\FormularioBorrarReserva;

$returnLocationForm = new FormularioActualizarReturnLocationReserva();
$htmlFormReturnLocation = $returnLocationForm->gestiona();
$pickupTimeForm = new FormularioActualizarPickupTimeReserva();
$htmlFormPickupTime = $pickupTimeForm->gestiona();
$returnTimeForm = new FormularioActualizarReturnTimeReserva();
$htmlFormReturnTime = $returnTimeForm->gestiona();
$deleteForm = new FormularioBorrarReserva();
$htmlDeleteForm = $deleteForm->gestiona();

$tituloPagina = 'Modificar reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Modificar reserva de vehiculo</h1>
<h3>Modificar localizacion de devolucion</h3>
$htmlFormReturnLocation
<h3>Modificar hora de recogida</h3>
$htmlFormPickupTime
<h3>Modificar hora de devolucion</h3>
$htmlFormReturnTime
<h3>Eliminar reserva</h3>
$htmlDeleteForm
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
