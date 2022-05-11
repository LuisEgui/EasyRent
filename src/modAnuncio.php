<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioActualizarReleaseDateAd;
use easyrent\includes\forms\FormularioActualizarEndDateAd;
use easyrent\includes\forms\FormularioActualizarBannerAd;

$bannerForm = new FormularioActualizarBannerAd();
$htmlFormBanner = $bannerForm->gestiona();
$releaseDateForm = new FormularioActualizarReleaseDateAd();
$htmlFormReleaseDate = $releaseDateForm->gestiona();
$endDateForm = new FormularioActualizarEndDateAd();
$htmlFormEndDate = $endDateForm->gestiona();

$tituloPagina = 'Modificar anuncio';

$contenidoPrincipal = <<<EOS
<h2>Modificar banner</h2>
$htmlFormBanner
<h2>Modificar fecha de inicio</h2>
$htmlFormReleaseDate
<h2>Modificar fecha final</h2>
$htmlFormEndDate
EOS;

require __DIR__.'\includes\vistas\plantillas\plantilla.php';
