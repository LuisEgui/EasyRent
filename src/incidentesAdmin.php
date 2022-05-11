<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/DamageService.php';
require_once __DIR__.'/includes/Damage.php';
require_once __DIR__.'/includes/DamageList.php';
require_once __DIR__.'/includes/FormularioRegistroIncidente.php';


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
            <th>ID Imagen</th>
            <th>Area</th>
			<th>Tipo</th>
            <th>Reparado</th>
            <th>Fecha de modificacion</th>
        </tr>
EOS; 
foreach($damagesList->getArray() as $damage) {
    $state = "No";
    if($damage->getIsRepaired()){
        $state = "Si";
    }
    $contenidoPrincipal .= <<<EOS
        <tr>
            <td>{$damage->getId()}</td>
            <td>{$damage->getUser()}</td>
            <td>{$damage->getVehicle()}</td>
            <td>{$damage->getTitle()}</td>
            <td>{$damage->getDescription()}</td>
            <td>{$damage->getEvidenceDamage()}</td>
            <td>{$damage->getArea()}</td>
            <td>{$damage->getType()}</td>
            <td>{$state}</td>
            <td>{$damage->getTimeStamp()}</td>
            <td> <a href="borrarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damage->getId();
        $contenidoPrincipal .= <<<EOS
            ">Borrar</a></td>
            <td> <a href="actualizarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damage->getId();
        $contenidoPrincipal .= <<<EOS
            ">Editar</a></td>
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
    </div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
