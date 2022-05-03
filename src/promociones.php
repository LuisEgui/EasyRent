<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Promociones';

$contenidoPrincipal = <<<EOS
  <div class="promociones">
    <h2>Mis promociones</h2>

    <div id="promo">
    <h4>Pack S</h4>
    <p>
      10% de descuento para nuevos clientes
    </p>
    </div>

    <div id="promo">
    <h4>Pack M</h4>
    <p>
      20% de descuento al completar 20 reservas
    </p>
    </div>
	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
