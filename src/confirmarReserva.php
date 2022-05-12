<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioConfirmarReserva;

$confirmationForm = new FormularioConfirmarReserva();
$htmlFormConfirm = $confirmationForm->gestiona();

$tituloPagina = 'Confirmar reserva de vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Confirmar reserva de vehiculo</h1>
$htmlFormConfirm
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
