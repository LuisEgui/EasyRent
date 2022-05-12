<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarMensaje;

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioActualizarMensaje($idMensaje);
$htmlFormRegMessage = $form->gestiona();

$tituloPagina = 'Registro de Modificación';

$contenidoPrincipal = <<<EOS
<h1>Registro de Modificación</h1>
$htmlFormRegMessage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
