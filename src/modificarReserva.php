<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioBorrarReserva.php';
require_once __DIR__.'/includes/FormularioActualizarReturnLocationReserva.php';
require_once __DIR__.'/includes/FormularioActualizarPickupTimeReserva.php';
require_once __DIR__.'/includes/FormularioActualizarReturnTimeReserva.php';

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