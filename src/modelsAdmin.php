<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\lists\ModelList;
use easyrent\includes\service\ModelService;

$modelService = ModelService::getInstance();

$defaultFunctions = array('cmpBrand', 'cmpModel', 'cmpCategory', 'cmpGearbox', 'cmpFuelType', 'cmpSeatCount', 'cmpFecha');
$functionNames = ['cmpBrand' => 'Marca', 'cmpModel' => 'Modelo', 'cmpCategory' => 'Categoria', 'cmpGearbox' => 'Caja de cambios', 'cmpFuelType' => 'Tipor de combustible', 'cmpSeatCount' => 'Numero de asientos', 'cmpFecha' => 'Fecha de modificacion'];


$modelsList = new ModelList($modelService->readAllModels());

if(isset($_GET['orderModelsBy']) && in_array($_GET['orderModelsBy'], $defaultFunctions)){
    $modelsList->orderBy($_GET['orderModelsBy']);
}

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/modelsAdmin.php?orderModelsBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Administrar modelos';

$contenidoPrincipal = <<<EOS
    <div>
    <h2 class="adminClass">Lista de modelos</h2>
    <div class="dropdown">
    <button class="dropbtn" style="float:left">Filtros</button>
    <div class="dropdown-content">
    $filterSelector
    </div>
    </div>
    <div class="listAdmin">
    <table>
        <tr>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Submodelo</th>
            <th>Categoria</th>
            <th>Caja de cambios</th>
            <th>Tipo de combustible</th>
            <th>Numero de asientos</th>
            <th>ID Imagen</th>
            <th>Fecha de modificacion</th>
        </tr>
EOS;
foreach($modelsList->getArray() as $model) {
    $contenidoPrincipal .= <<<EOS
        <tr>
            <td>{$model->getBrand()}</td>
            <td>{$model->getModel()}</td>
            <td>{$model->getSubmodel()}</td>
            <td>{$model->getCategory()}</td>
            <td>{$model->getGearbox()}</td>
            <td>{$model->getFuelType()}</td>
            <td>{$model->getSeatCount()}</td>
            <td>{$model->getImage()}</td>
            <td>{$model->getTimeStamp()}</td>
        </tr>
    EOS;
}
$contenidoPrincipal .= <<<EOS
    </table>
    </div>
    </div>
    <div>
    <div class="infoButton">
    <a href="nuevoModelo.php">Añadir modelo</a>
    </div>
    <div class="infoButton">
    <a href="borrarModelo.php">Borrar modelo</a>
    </div>
    <div id="anteriorUrl">
    <a href="admin.php">Atrás</a>
    </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
