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
<h2 class="adminClass">Modificar contraseña</h2>
$htmlFormPassword
<h2 class="adminClass">Modificar email</h2>
$htmlFormEmail
<h2 class="adminClass">Modificar imagen de usuario</h2>
$htmlFormUserImg
<h2 class="adminClass">Modificar el role de usuario</h2>
$htmlRoleForm
<h2 class="adminClass">Eliminar cuenta</h2>
$htmlDeleteForm
EOS;

require __DIR__.'\includes\vistas\plantillas\plantilla.php';
