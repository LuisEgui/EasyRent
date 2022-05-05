<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioReserva.php';

$form = new FormularioReserva();
$htmlFormReserve = $form->gestiona();

$tituloPagina = 'Reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Reserva de vehiculo</h1>
$htmlFormReserve
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';