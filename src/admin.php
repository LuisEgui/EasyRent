<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Admin';

$contenidoPrincipal = <<<EOS
    <div class="promociones">
    <h2>Administrar</h2>
    <div id="info">
    <a href="nuevoVehiculo.php">Añadir vehiculo</a>
    </div>
    <div id="info">
    <a href="borrarVehiculo.php">Borrar vehiculo</a>
    </div>
    <div id="info">
    <a href="mostrarVehiculosAdminPanel.php">Mostrar vehiculos</a>
    </div>
	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
