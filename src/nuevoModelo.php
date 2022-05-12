<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioRegistroModelo;

$form = new FormularioRegistroModelo();
$htmlFormRegModel = $form->gestiona();

$tituloPagina = 'Registro de Modelo';

$contenidoPrincipal = <<<EOS
<h1>Registrar Modelo</h1>
$htmlFormRegModel
<div id="anteriorUrl">
    <a href="modelsAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';