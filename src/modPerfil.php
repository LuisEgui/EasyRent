<?php

require_once __DIR__.'\includes\config.php';
require_once __DIR__.'\includes\FormularioActualizarUsuario.php';

$form = new FormularioActualizarUsuario();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Modificar contraseña';

$contenidoPrincipal = <<<EOS
<h1>Modificar contraseña</h1>
$htmlFormLogin
EOS;

require __DIR__.'\includes\vistas\plantillas\plantilla.php';
