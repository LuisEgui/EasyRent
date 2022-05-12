<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioRegistroVehiculo;

$form = new FormularioRegistroVehiculo();
$htmlFormRegVehicle = $form->gestiona();

$tituloPagina = 'Registro de Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Registrar Vehiculo</h1>
$htmlFormRegVehicle
<div id="anteriorUrl">
    <a href="vehiclesAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
