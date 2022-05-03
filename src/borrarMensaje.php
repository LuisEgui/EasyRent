<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioEliminarMensaje.php';

$form = new FormularioEliminarMensaje();
$htmlFormDelMessage = $form->gestiona();

$tituloPagina = 'Eliminar mensaje';

$contenidoPrincipal = <<<EOS
<h1>Eliminar mensaje</h1>
$htmlFormDelMessage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
