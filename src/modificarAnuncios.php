<?php
require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\AdvertisementService;

$advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
$tituloPagina = 'Lista anuncios';
$ads = $advertisementService->readAllAds();
$contenidoPrincipal = <<<EOS
<h1>Ad list</h1>
EOS;
for ($i = 0; $i < count($ads); $i++) {
    $contenidoPrincipal .= <<<EOS
    <div class="v">
        <h2>Advertisement
    EOS;
    $contenidoPrincipal .= $i + 1;
    $contenidoPrincipal .= <<<EOS
        </h2>
        <p>
        Banner:
    EOS;
    $contenidoPrincipal .= $ads[$i]->getBanner();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Release date:
    EOS;
    $contenidoPrincipal .= $ads[$i]->getReleaseDate();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        End date:
    EOS;
    $contenidoPrincipal .= $ads[$i]->getEndDate();
    $contenidoPrincipal .= <<<EOS
        </p>
        <p>
        Priority:
    EOS;
    $contenidoPrincipal .= $ads[$i]->getPriority();
    $contenidoPrincipal .= <<<EOS
        <p>
    EOS;
    $contenidoPrincipal .= <<<EOS
    </p>
    <a href="modAnuncio.php?id=
    EOS;
    $contenidoPrincipal .= $ads[$i]->getId();
    $contenidoPrincipal .= <<<EOS
    ">Modificar</a>
    </div>
    EOS;

}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';