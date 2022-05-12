<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Admin';

$contenidoPrincipal = <<<EOS
    <div class="administracion">
    <h2>Administrar</h2>
    <div class="info">
    <a href="vehiclesAdmin.php">Administrar vehiculos</a>
    </div>
    <div class="info">
    <a href="modelsAdmin.php">Administrar modelo</a>
    </div>
    <div class="info">
        <a href="reservasAdmin.php">Administrar reservas</a>
    </div>
    <div class="info">
    <a href="nuevoAnuncio.php">Añadir anuncio</a>
    </div>
    <div class="info">
    <a href="modificarAnuncios.php">Modificar anuncios</a>
    </div>
	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
