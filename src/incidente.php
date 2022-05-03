<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'Incidentes';

$contenidoPrincipal = <<<EOS
    <div class="incidentes">
    <h2>Gestionar Incidentes</h2>
    <div id="info">
    <a href="mostrarIncidentes.php">Lista de incidentes</a> 
    </div>
    <div id="info">
    <a href="borrarIncidente.php">Borrar incidente</a> 
    </div>
    <div id="info">
    <a href="anadirIncidente.php">Añadir incidente</a>
    </div>
    <div id="info">
    <a href="actualizarIncidente.php">Actualizar incidente</a>
    </div>
	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
