<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarIncidente.php';

$idDamage = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioActualizarIncidente($idDamage);
$htmlFormRegDamage = $form->gestiona();

$tituloPagina = 'Registro de Modificación';

$contenidoPrincipal = <<<EOS
<h1>Registro de Modificación</h1>
$htmlFormRegDamage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';