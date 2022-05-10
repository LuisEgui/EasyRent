<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarEmailUsuario;
use easyrent\includes\forms\FormularioActualizarImagenUsuario;
use easyrent\includes\forms\FormularioActualizarPasswordUsuario;
use easyrent\includes\forms\FormularioActualizarRoleUsuario;
use easyrent\includes\forms\FormularioBorrarCuenta;

$passwordForm = new FormularioActualizarPasswordUsuario();
$htmlFormPassword = $passwordForm->gestiona();
$emailForm = new FormularioActualizarEmailUsuario();
$htmlFormEmail = $emailForm->gestiona();
$userImgForm = new FormularioActualizarImagenUsuario();
$htmlFormUserImg = $userImgForm->gestiona();
$roleForm = new FormularioActualizarRoleUsuario();
$htmlRoleForm = $roleForm->gestiona();
$deleteForm = new FormularioBorrarCuenta();
$htmlDeleteForm = $deleteForm->gestiona();

$tituloPagina = 'Modificar perfil';

$contenidoPrincipal = <<<EOS
<h2>Modificar contraseña</h2>
$htmlFormPassword
<h2>Modificar email</h2>
$htmlFormEmail
<h2>Modificar imagen de usuario</h2>
$htmlFormUserImg
<h2>Modificar el role de usuario</h2>
$htmlRoleForm
<h2>Eliminar cuenta</h2>
$htmlDeleteForm
EOS;

require __DIR__.'\includes\vistas\plantillas\plantilla.php';
