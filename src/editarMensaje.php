<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarMensaje.php';

$form = new FormularioActualizarMensaje();
$htmlFormEdMessage = $form->gestiona();

$tituloPagina = 'Editar mensaje';

$contenidoPrincipal = <<<EOS
<h1>Editar mensaje</h1>
$htmlFormEdMessage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
