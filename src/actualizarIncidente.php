<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarDatosIncidente;

$idDamage = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioActualizarDatosIncidente($idDamage);
$htmlFormRegDamage = $form->gestiona();

$tituloPagina = 'Registro de Modificación';

$contenidoPrincipal = <<<EOS
<h1>Registro de Modificación</h1>
$htmlFormRegDamage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';