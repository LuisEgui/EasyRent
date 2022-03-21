<?php

require_once __DIR__.'\includes\config.php';
require_once __DIR__.'\includes\FormularioRegistroUsuario.php';

$form = new FormularioRegistroUsuario();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Registro de Usuario';

$contenidoPrincipal = <<<EOS
<h1>Registro de Usuario</h1>
$htmlFormLogin
EOS;

require __DIR__.'\includes\plantillas\plantillas.php';
