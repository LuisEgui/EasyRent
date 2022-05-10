<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioEliminarVehiculo;

$form = new FormularioEliminarVehiculo();
$htmlFormDeleteVehicle = $form->gestiona();

$tituloPagina = 'Eliminar Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Eliminar Vehiculo</h1>
$htmlFormDeleteVehicle
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
