<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioEliminarModelo;

$defaultFunctions = array('cmpBrand', 'cmpModel', 'cmpFecha');
$functionNames = ['cmpBrand' => 'Marca', 'cmpModel' => 'Modelo', 'cmpFecha' => 'Fecha de modificacion'];

$orderByFunction = null;

if(isset($_GET['orderModelsBy']) && in_array($_GET['orderModelsBy'], $defaultFunctions)){
    $orderByFunction = $_GET['orderModelsBy'];
}

$form = new FormularioEliminarModelo($orderByFunction);

$htmlFormDeleteModel = $form->gestiona();

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/borrarModelo.php?orderModelsBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Eliminar Modelo';

$contenidoPrincipal = <<<EOS
<h1>Eliminar Modelo</h1>
<div class="dropdown">
<button class="dropbtn" style="float:left">Filtros</button>
<div class="dropdown-content">
$filterSelector
</div>
</div>
$htmlFormDeleteModel
<div id="anteriorUrl">
    <a href="modelsAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
