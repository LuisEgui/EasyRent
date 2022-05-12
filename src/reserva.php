<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioReserva;

$form = new FormularioReserva();
$htmlFormReserve = $form->gestiona();

$tituloPagina = 'Reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Reserva de vehiculo</h1>
$htmlFormReserve
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
