<?php

require_once __DIR__.'\includes\config.php';
require_once __DIR__.'\includes\FormularioVehiculo.php';
require_once __DIR__.'\Vehiculo.php';

//$form = new FormularioVehiculo();
//$htmlFormVehiculo = $form->gestiona();

$tituloPagina = 'Lista vehiculos';
$vehiculos = Vehiculo::buscaPorFiltros();
$contenidoPrincipal = <<<EOS
<h1>Listar vehiculos</h1>
EOS;
$contenidoPrincipal .= $vehiculos[0]->getVin();
$contenidoPrincipal .= $vehiculos[1]->getVin();
$contenidoPrincipal .= $vehiculos[1]->getLicensePlate();
$contenidoPrincipal .= $vehiculos[1]->getModel();
$contenidoPrincipal .= $vehiculos[1]->getFuelType();
$contenidoPrincipal .= $vehiculos[1]->getSeatCount();
$contenidoPrincipal .= $vehiculos[1]->getState();
require __DIR__.'\includes\vistas\plantillas\plantilla.php';
