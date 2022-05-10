<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioRegistroUsuario;

$form = new FormularioRegistroUsuario();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Registro de Usuario';

$contenidoPrincipal = <<<EOS
<h1>Registro de Usuario</h1>
$htmlFormLogin
EOS;

require __DIR__.'\includes\vistas\plantillas\plantilla.php';
