<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioResponderMensaje.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioResponderMensaje($idMensaje);
$htmlFormRegAnswer = $form->gestiona();

$tituloPagina = 'Registro de Respuesta';

$contenidoPrincipal = <<<EOS
<h1>Registro de Respuesta</h1>
$htmlFormRegAnswer
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
