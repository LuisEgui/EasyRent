<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioAnuncio;

$form = new FormularioAnuncio();
$htmlFormNewAd = $form->gestiona();

$tituloPagina = 'Registro de Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Nuevo anuncio</h1>
$htmlFormNewAd
EOS;
require __DIR__.'\includes\vistas\plantillas\plantilla.php';
