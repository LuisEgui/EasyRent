<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Foro';

$contenidoPrincipal = <<<EOS
<div>
    <div class="mensaje">
    <div class="cabecera">
        <h4>Aparcamiento centro de madrid</h4>
    </div>
    <div class="contenido">
        <p>¿Cuál es el mejor parking por Gran Vía?</p>
    </div>
    </div>
</div>

<div>
    <div class="mensaje">
    <div class="cabecera">
        <h4>Respuesta</h4>
    </div>
    <div class="contenido">
        <p>No aparquéis en el que está en el metro de Sevilla porque se llena rápido. Es mejor aparcar en el siguiente</p>
    </div>
    </div>
</div>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
