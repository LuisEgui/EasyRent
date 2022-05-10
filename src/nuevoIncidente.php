<?php

//require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistroIncidente.php';


$form = new FormularioRegistroIncidente();
$htmlFormRegDamage = $form->gestiona();

$tituloPagina = 'Registro de Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Registrar Vehiculo</h1>
$htmlFormRegDamage
<div id="anteriorUrl">
    <a href="incidentesAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';