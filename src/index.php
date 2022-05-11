<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioBuscarVehiculo.php';

$searchForm = new FormularioBuscarVehiculo();
$htmlFormSearch = $searchForm->gestiona();

$tituloPagina = 'Index';

$contenidoPrincipal = <<<EOS
  $htmlFormSearch

  <div class="promociones">
    <h2>Promociones</h2>
    <div id="info">
    <h3>Información</h3>
    <p>
      EasyRent es un negocio dedicado al alquiler de coches de forma online.
      Las promociones se renuevan con frecuencia.
    </p>
    </div>

    <div id="promo-s">
    <h4>Pack S</h4>
    <p>
      10% de descuento para nuevos clientes
    </p>
    </div>

    <div id="promo-m">
    <h4>Pack M</h4>
    <p>
      20% de descuento al completar 20 reservas
    </p>
    </div>
	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';