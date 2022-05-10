<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'Admin';

$contenidoPrincipal = <<<EOS
    <div class="promociones">
    <h2>Administrar</h2>
    <div id="info">
    <a href="vehiclesAdmin.php">Administrar vehiculos</a>
    </div>
    <div id="info">
    <a href="modelsAdmin.php">Administrar modelo</a>
    </div>
    <div id="info">
    <a href="incidentesAdmin.php">Administrar incidentes</a>
    </div>
	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
