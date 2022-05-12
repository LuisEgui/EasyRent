<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Contacto';

$contenidoPrincipal = <<<EOS
  <div class="promociones">
    <h2 class="tituloPagina">Atencion al cliente</h2>
    <div id="infoContacto">
    <h3>Información</h3>
    <p>
      EasyRent es un negocio dedicado al alquiler de coches de forma online.
      Contacta aquí.
    </p>
    </div>

    <div class="cuadroAtCliente">
    <h4>Teléfono S</h4>
    <p>
      666666666
    </p>
    </div>

    <div class="cuadroAtCliente">
    <h4>Ticket</h4>
    <p>
      ticket
    </p>
    </div>

    <div class="cuadroAtCliente">
    <h4>Email</h4>
    <p>
      contacto@easyrent.com
    </p>
    </div>
	</div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
