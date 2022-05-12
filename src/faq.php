<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'FAQ';

$contenidoPrincipal = <<<EOS
    <h2 class="adminClass">Preguntas frecuentes</h2>
    <div class="promociones">

    <div class="cuadroAtCliente">
    <h4>Ya tengo mi reserva</h4>
    </div>

    <div class="cuadroAtCliente">
    <h4>Devolución del vehículo</h4>
    </div>

    <div class="cuadroAtCliente">
    <h4>Otras FAQ</h4>
    </div>

    <div class="cuadroAtCliente">
    <a class="adminClass" href="faqantes.php">Antes de alquilar</a>
    </div>

	</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
