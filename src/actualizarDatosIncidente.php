<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioActualizarDatosIncidente.php';

$idDamageToUpdate = null;

if(isset($_GET['idDamageToUpdate'])){
    $idDamageToUpdate = $_GET['idDamageToUpdate'];
}

$form = new FormularioActualizarDatosIncidente($idDamageToUpdate);

$htmlFormUpdateDamageData = $form->gestiona();

$tituloPagina = 'Actualizar Vehiculo';

$contenidoPrincipal = <<<EOS
<h1>Actualizar Vehiculo</h1>
$htmlFormUpdateDamageData
<div id="anteriorUrl">
    <a href="incidentesAdmin.php">Cancelar</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
