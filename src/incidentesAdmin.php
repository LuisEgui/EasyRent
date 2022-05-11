<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/DamageService.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/Damage.php';
require_once __DIR__.'/includes/DamageList.php';


$damageService = DamageService::getInstance();
$userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);

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
        </tr>
    EOS;
}  
$contenidoPrincipal .= <<<EOS
    </table>
    </div>
    </div>
    <div>
    <div id="info">
    <a href="nuevoIncidente.php">Añadir incidente</a>
    </div>
    <div id="info">
    <a href="borrarIncidente.php">Borrar incidente</a>
    </div>
	<div id="info">
    <a href="actualizarIncidente.php">Actualizar incidente</a>
    </div>
    <div id="anteriorUrl">
    <a href="admin.php">Atrás</a>
    </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

/*if (count($damages) > 0){
for ($i = 0; $i < count($damages); $i++) {
		$contenidoPrincipal .= <<<EOS
		<div class="v">
			<h1>Incidencia: 
		EOS;
		$contenidoPrincipal .= <<<EOS
			</h1>
			<p>Vehiculo: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getVehicle();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Usuario: 
		EOS;
        $usuario = $userService->readUserById($damages[$i]->getUser());
		$contenidoPrincipal .= $usuario->getEmail();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Titulo: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getTitle();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Descripcion: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getDescription();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Imagen: 
		EOS;
        if($damages[$i]->getEvidenceDamage() != NULL){
		    $contenidoPrincipal .= $damages[$i]->getEvidenceDamage();
        } else {
            $contenidoPrincipal .= <<<EOS
                 No se incluye imagen
            EOS;
        }
        $contenidoPrincipal .= <<<EOS
		</p>
		EOS;
        $contenidoPrincipal .= <<<EOS
		<p>Area: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getArea();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Type: 
		EOS;
        $contenidoPrincipal .= $damages[$i]->getType();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>¿Está reparado?: 
		EOS;
        if($damages[$i]->getIsRepaired() == true){
            $contenidoPrincipal .= <<<EOS
            <p>SÍ</p>
            </p>
            EOS;
        } else {
            $contenidoPrincipal .= <<<EOS
            <p>NO</p>
            EOS;
        }
        $contenidoPrincipal .= <<<EOS
        <a href="borrarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damages[$i]->getId();
        $contenidoPrincipal .= <<<EOS
            ">Borrar</a>
        EOS;
        $contenidoPrincipal .= <<<EOS
            <a href="actualizarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damages[$i]->getId();
        $contenidoPrincipal .= <<<EOS
            ">Editar</a> 
        EOS;
        $contenidoPrincipal .= <<<EOS
        </div>
        EOS;
        

}
}
$form = new FormularioRegistroIncidente();
	$htmlFormRegMessage = $form->gestiona();

	$tituloPagina = 'Agregar incidente';

	$contenidoPrincipal .= <<<EOS
	<h1>Nuevo incidente</h1>
	$htmlFormRegMessage
	EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
*/
