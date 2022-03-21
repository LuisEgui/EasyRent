<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';

$tituloPagina = 'FAQAntes';

$contenidoPrincipal = <<<EOS
  <div class="promociones">
    <div id="info">
    <h3>Preguntas frecuentes antes de alquilar</h3>
    </div>

    <div>
    <h4>¿Puedo alquilar con 18 años?</h4>
    <p>
      Es necesario tener, al menos, 3 años de carnet.
    </p>
    </div>

    <div>
    <h4>¿Qué documentos necesito para poder alquilar un coche?</h4>
    <p>
      Se necesita carnet de identidad y de conducir, ambos en regla.
    </p>
    </div>

    <div>
    <h4>¿Puedo llevar mascotas en un coche?</h4>
    <p>
      Siempre que se protejan los asientos.
    </p>
    </div>

	</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';