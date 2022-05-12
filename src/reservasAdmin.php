<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\lists\ReserveList;
use easyrent\includes\service\ReserveService;

$reserveService = ReserveService::getInstance();

$defaultFunctions = array('cmpId', 'cmpVIN', 'cmpUser', 'cmpPickupLocation', 'cmpReturnLocation', 'cmpPickupDate', 'cmpReturnDate', 'cmpPrice', 'cmpState');
$functionNames = ['cmpId' => 'ID Reserva', 'cmpVIN' => 'VIN Vehiculo', 'cmpUser' => 'ID Usuario', 'cmpPickupLocation' => 'Ubicacion recogida', 'cmpReturnLocation' => 'Ubicacion devolucion', 'cmpPickupDate' => 'Fecha recogida', 'cmpReturnDate' => 'Fecha devolucion', 'cmpPrice' => 'Precio', 'cmpState' => 'Estado'];

$reservesList = new ReserveList($reserveService->getAllReserves());

if(isset($_GET['orderReservesBy']) && in_array($_GET['orderReservesBy'], $defaultFunctions)){
    $reservesList->orderBy($_GET['orderReservesBy']);
}

$rutaApp = RUTA_APP;
$filterSelector = '';
if(!empty($defaultFunctions)){
    foreach($defaultFunctions as $function) {
        $filterSelector .= "<a href=\"{$rutaApp}/src/reservasAdmin.php?orderReservesBy={$function}\">{$functionNames[$function]}</a>";
    }
}
$filterSelector .= '';

$tituloPagina = 'Lista reservas';

$contenidoPrincipal = <<<EOS
    <div>
    <h2 class="adminClass">Lista de reservas</h2>
    <div class="dropdown">
    <button class="dropbtn" style="float:left">Filtros</button>
    <div class="dropdown-content">
    $filterSelector
    </div>
    </div>
    <div class="listAdmin">
    <table>
        <tr>
            <th>ID Reserva</th>
            <th>VIN Vehiculo</th>
            <th>ID Usuario</th>
            <th>Ubicacion recogida</th>
            <th>Ubicacion devolucion</th>
            <th>Fecha recogida</th>
            <th>Fecha devolucion</th>
            <th>Precio</th>
            <th>Estado</th>
        </tr>
EOS;
foreach($reservesList->getArray() as $reserve) {
    //$vehicleModel = $modelService->readModelById($vehicle->getModel());
    $contenidoPrincipal .= <<<EOS
        <tr>
            <td>{$reserve->getId()}</td>
            <td>{$reserve->getVehicle()}</td>
            <td>{$reserve->getUser()}</td>
            <td>{$reserve->getPickUpLocation()}</td>
            <td>{$reserve->getReturnLocation()}</td>
            <td>{$reserve->getPickUpTime()}</td>
            <td>{$reserve->getReturnTime()}</td>
            <td>{$reserve->getPrice()}</td>
            <td>{$reserve->getState()}</td>
        </tr>
    EOS;
}
$contenidoPrincipal .= <<<EOS
    </table>
    </div>
    </div>
    <div>
    <div class="infoButton">
    <a href="modifyReserveAdmin.php">Modificar o borrar reserva</a>
    </div>
    <div id="anteriorUrl">
    <a href="admin.php">Atrás</a>
    </div>
    </div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
