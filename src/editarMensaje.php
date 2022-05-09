<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarMensaje.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioActualizarMensaje($idMensaje);
$htmlFormRegMessage = $form->gestiona();

$tituloPagina = 'Registro de Modificación';

$contenidoPrincipal = <<<EOS
<h1>Registro de Modificación</h1>
$htmlFormRegMessage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';