<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'Admin';

$contenidoPrincipal = <<<EOS
    <div class="promociones">
    <h2>Administrar</h2>
    <div id="info">
    <a href="nuevoVehiculo.php">Añadir vehiculo</a> 
    </div>

	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';