<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'Index';

$contenidoPrincipal = <<<EOS
<div class="buscadorVehiculo">
    <form id="inrow" action="mostrarVehiculos.php" method="POST">
    <div>
        <label for="ubi">Ubicación de recogida: </label>
        <input type="text" id="ubi" name="ubicacion" />
    </div>
    <div>
        <label for="rec">Recogida: </label>
        <input type="date" id="rec" name="recogida" />
    </div>
    <div>
        <label for="dev">Devolución: </label>
        <input type="date" id="dev" name="devolucion"/>
    </div>
    <div>
        <input type="submit" name="buscar" value="Buscar"/>
    </div>
    </form>
	</div>

  <div class="promociones">
    <h2>Promociones</h2>
    <div id="info">
    <h3>Información</h3>
    <p>
      EasyRent es un negocio dedicado al alquiler de coches de forma online.
      Las promociones se renuevan con frecuencia.
    </p>
    </div>

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