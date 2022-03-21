<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioVehiculo.php';

$form = new FormularioVehiculo();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'AñadirVehiculo';

$contenidoPrincipal = <<<EOS
<h1>Nuevo vehiculo</h1>
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';