<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistroVehiculo.php';

$form = new FormularioRegistroVehiculo();
$htmlFormRegVehicle = $form->gestiona();

$tituloPagina = 'Registro de Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Registro de Vehiculo</h1>
$htmlFormRegVehicle
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
