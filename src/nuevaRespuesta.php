<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioResponderMensaje.php';

$form = new FormularioResponderMensaje();
$htmlFormRegAnswer = $form->gestiona();

$tituloPagina = 'Registro de Respuesta';

$contenidoPrincipal = <<<EOS
<h1>Registro de Respuesta</h1>
$htmlFormRegAnswer
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
