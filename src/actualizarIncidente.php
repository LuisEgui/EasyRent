<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarIncidente.php';

$defaultFunctions = array('cmpID', 'cmpUser', 'cmpVehicle', 'cmpType', 'cmpIsRepaired', 'cmpFecha');
$functionNames = ['cmpID' => 'ID Incidente', 'cmpUser' => 'ID Usuario', 'cmpVehicle' => 'VIN ', 'cmpType' => 'Tipo de incidencia', 'cmpIsRepaired' => 'Estado de reparacion', 'cmpFecha' => 'Fecha de modificacion'];

$orderByFunction = null;

if(isset($_GET['orderDamagesBy']) && in_array($_GET['orderDamagesBy'], $defaultFunctions)){
    $orderByFunction = $_GET['orderDamagesBy'];
}

$form = new FormularioActualizarIncidente($orderByFunction);

$htmlFormUpdateDamage = $form->gestiona();

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/actualizarIncidente.php?orderDamagesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Actualizar Incidente';

$contenidoPrincipal = <<<EOS
<h1>Actualizar Incidente</h1>
<div class="dropdown">
<button class="dropbtn" style="float:left">Filtros</button>
<div class="dropdown-content">
$filterSelector
</div>
</div>
$htmlFormUpdateDamage
<div id="anteriorUrl">
    <a href="incidentesAdmin.php">Cancelar</a>
</div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarIncidente.php';

$idDamage = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioActualizarIncidente($idDamage);
$htmlFormRegDamage = $form->gestiona();

$tituloPagina = 'Registro de Modificación';

$contenidoPrincipal = <<<EOS
<h1>Registro de Modificación</h1>
$htmlFormRegDamage
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';