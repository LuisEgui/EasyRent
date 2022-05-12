<?php

require_once 'vendor/autoload.php';
require_once __DIR__ . '/src/includes/config/config.php';

use easyrent\includes\forms\FormularioBuscarVehiculo;

$searchForm = new FormularioBuscarVehiculo();
$htmlFormSearch = $searchForm->gestiona();

$tituloPagina = 'Index';

$contenidoPrincipal = <<<EOS
  $htmlFormSearch

  <div class="promociones">
    <h2 class="tituloProm">Promociones</h2>
    <div class="infoIndex">
    <h3>Información</h3>
    <p>
      EasyRent es un negocio dedicado al alquiler de coches de forma online.
      Las promociones se renuevan con frecuencia.
    </p>
    </div>

    <div class="packLeft" id="promo-s">
    <h4>Pack S</h4>
    <p>
      10% de descuento para nuevos clientes
    </p>
    </div>

    <div class="packRight" id="promo-m">
    <h4>Pack M</h4>
    <p>
      20% de descuento al completar 20 reservas
    </p>
    </div>
	</div>

EOS;


require __DIR__ . '/src/includes/vistas/plantillas/plantillaIndex.php';
