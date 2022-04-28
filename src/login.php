<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioLogin;

$form = new FormularioLogin();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
<h1>Acceso al sistema</h1>
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
