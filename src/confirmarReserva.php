<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioConfirmarReserva.php';

$confirmationForm = new FormularioConfirmarReserva();
$htmlFormConfirm = $confirmationForm->gestiona();

$tituloPagina = 'Confirmar reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Confirmar reserva de vehiculo</h1>
$htmlFormConfirm
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';