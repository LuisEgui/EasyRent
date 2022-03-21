<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$rutaApp = RUTA_APP;

$tituloPagina = 'Perfil';

$contenidoPrincipal = <<<EOS
<div class="buscadorVehiculo">
    <h2>Nombre cliente</h2>
    <p>Datos</p>
    <a href='{$rutaApp}/src/modperfil.php'>Modificar datos</a>
	</div>


  <div class="promociones">
    <h2>Reservas</h2>
    <h4>Reservas activas</h4>
    <p>Reserva 1</p>
    <h4>Reservas anteriores</h4>
    <p>Reserva Julio</p>
    <h2>Factores</h2>
    </div>
	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';