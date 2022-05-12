<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\DamageService;
use easyrent\includes\service\lists\DamageList;
use easyrent\includes\forms\FormularioRegistroIncidente;

$damageService = DamageService::getInstance();

$defaultFunctions = array('cmpID', 'cmpUser', 'cmpVehicle', 'cmpType', 'cmpIsRepaired', 'cmpFecha');
$functionNames = ['cmpID' => 'ID Incidente', 'cmpUser' => 'ID Usuario', 'cmpVehicle' => 'VIN ', 'cmpType' => 'Tipo de incidencia', 'cmpIsRepaired' => 'Estado de reparacion', 'cmpFecha' => 'Fecha de modificacion'];

$damagesList = new DamageList($damageService->readAllDamages());

if(isset($_GET['orderDamagesBy']) && in_array($_GET['orderDamagesBy'], $defaultFunctions)){
    $damagesList->orderBy($_GET['orderDamagesBy']);
}

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/incidentesAdmin.php?orderDamagesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Administrar incidentes';

$contenidoPrincipal = <<<EOS
    <div>
    <h2>Lista de incidentes</h2>
    <div class="dropdown">
    <button class="dropbtn" style="float:left">Filtros</button>
    <div class="dropdown-content">
    $filterSelector
    </div>
    </div>
    <div>
    <table>
        <tr>
            <th>ID Incidencia</th>
            <th>ID Usuario</th>
            <th>VIN Vehiculo</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Imagen</th>
            <th>Area</th>
			<th>Tipo</th>
            <th>Reparado</th>
            <th>Fecha de modificacion</th>
            <th></th>
            <th></th>
        </tr>
EOS;
foreach($damagesList->getArray() as $damage) {
    $state = "No";
    if($damage->getIsRepaired()){
        $state = "Si";
    }

    $damageImage = null;

    if ($damageService->getDamageImage($damage->getEvidenceDamage())) {
        $damageImage = $damage->getEvidenceDamage() . "-" . $damageService->getDamageImage($damage->getEvidenceDamage())->getPath();
    }

    $contenidoPrincipal .= <<<EOS
        <tr>
            <td>{$damage->getId()}</td>
            <td>{$damage->getUser()}</td>
            <td>{$damage->getVehicle()}</td>
            <td>{$damage->getTitle()}</td>
            <td>{$damage->getDescription()}</td>
            <td><img src="includes/img/damage/$damageImage" width="50" height="50" alt="Imagen incidente"></td>
            <td>{$damage->getArea()}</td>
            <td>{$damage->getType()}</td>
            <td>{$state}</td>
            <td>{$damage->getTimeStamp()}</td>
            <td> <a href="borrarIncidente.php?id={$damage->getId()}">Borrar</a></td>
            <td> <a href="actualizarIncidente.php?id={$damage->getId()};">Editar</a></td>
        </tr>
    EOS;
}
$contenidoPrincipal .= <<<EOS
    </table>
    </div>
    </div>
EOS;
    $form = new FormularioRegistroIncidente();
	$htmlFormRegMessage = $form->gestiona();

	$tituloPagina = 'Agregar incidente';

	$contenidoPrincipal .= <<<EOS
	<h1>Nuevo incidente</h1>
	$htmlFormRegMessage
    <div id="anteriorUrl">
    <a href="admin.php">Atrás</a>
    </div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
