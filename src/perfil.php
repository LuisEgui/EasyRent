<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\UserService;

    $userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    $user = $userService->readUserByEmail($_SESSION['email']);

    $rutaApp = RUTA_APP;
    $rutaUserImages = RUTA_USER_IMAGES;

    $tituloPagina = 'Perfil';

    $contenidoPrincipal = <<<EOS
    <div class="infoclient">
    EOS;

if ($user) {
    $userEmail = $user->getEmail();

    $contenidoPrincipal .= <<<EOS
        <h2>{$userEmail}</h2>
        <p>Datos</p>
        EOS;

    $userImg = $userService->getUserImage();

    if ($userImg) {
        // Image relative path: <u_id> - <image-path>
        $imgPath = "{$userImg->getId()}-{$userImg->getPath()}";
        $contenidoPrincipal .= <<<EOS
            <div>
               <img src="includes/img/usr/$imgPath" width="125" height="75" alt="Imagen usuario"/>
            </div>
            EOS;
    }
} else {
    $contenidoPrincipal .= <<<EOS
        <h2>Nombre cliente</h2>
        <p>Datos</p>
        EOS;
}

    $contenidoPrincipal .= <<<EOS
    <a href='{$rutaApp}/src/modperfil.php'>Modificar datos</a>

    <div class="promociones">
    <h2>Reservas</h2>
    <h4>Reservas activas</h4>
    <p>Reserva 1</p>
    <h4>Reservas anteriores</h4>
    <p>Reserva Julio</p>
    <h2>Factores</h2>
    </div>
    </div>
    EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
