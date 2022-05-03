<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'Gestión de mensajes';

$contenidoPrincipal = <<<EOS
    <div class="mensajes">
    <h2>Gestionar</h2>
    <div id="info">
    <a href="nuevaRespuesta.php">Añadir respuesta</a>
    </div>
    <div id="info">
    <a href="borrarMensaje.php">Borrar mensaje</a> 
    </div>
    <div id="info">
    <a href="editarMensaje.php">Editar mensaje</a>
    </div>
	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';