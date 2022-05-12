<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'FAQAntes';

$contenidoPrincipal = <<<EOS
  <div class="promociones">
    <div id="info">
    <h3 class="adminClass">Preguntas frecuentes antes de alquilar</h3>
    </div>

    <div class="cuadroFaqAntes">
    <h4>¿Puedo alquilar con 18 años?</h4>
    <p>
      Es necesario tener, al menos, 3 años de carnet.
    </p>
    </div>

    <div class="cuadroFaqAntes">
    <h4>¿Qué documentos necesito para poder alquilar un coche?</h4>
    <p>
      Se necesita carnet de identidad y de conducir, ambos en regla.
    </p>
    </div>

    <div class="cuadroFaqAntes">
    <h4>¿Puedo llevar mascotas en un coche?</h4>
    <p>
      Siempre que se protejan los asientos.
    </p>
    </div>

	</div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
