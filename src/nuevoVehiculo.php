<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioRegistroVehiculo;

$form = new FormularioRegistroVehiculo();
$htmlFormRegVehicle = $form->gestiona();

$tituloPagina = 'Registro de Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Registro de Vehiculo</h1>
$htmlFormRegVehicle
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
