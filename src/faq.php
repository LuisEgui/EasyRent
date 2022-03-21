<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'FAQ';

$contenidoPrincipal = <<<EOS
    <h2>Preguntas frecuentes</h2>
    <div class="promociones">

    <div id="promo">
    <h4>Ya tengo mi reserva</h4>
    </div>

    <div id="promo">
    <h4>Devolución del vehículo</h4>
    </div>

    <div id="promo">
    <h4>Otras FAQ</h4>
    </div>

    <div id="promo">
    <a href="faqantes.php">Antes de alquilar</a> 
    </div>

	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';