<?php

require_once __DIR__.'/ReserveList.php';
require_once __DIR__.'/ReserveService.php';
require_once RAIZ_APP.'/Formulario.php';

class FormularioModificarReserva extends Formulario {

    private $reserveService;

    private $reservesList;

    private $orderReservesBy;

    public function __construct($orderByFunction) {
        parent::__construct('formUpdateReserve', ['urlRedireccion' => 'modificarReservaAdmin.php']);
        $this->reservesList = new ReserveList();
        $this->reserveService = ReserveService::getInstance();
        if(isset($orderByFunction)){
            $this->orderReservesBy = $orderByFunction;
        }
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista

        // Se leen todos los vehiculos de la base de datos y se almacenan en un array de la instancia de la clase VehicleList
        $this->reservesList->setArray($this->reserveService->getAllReserves());
        if(isset($this->orderReservesBy)){
            $this->reservesList->orderBy($this->orderReservesBy);
        }

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
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

        foreach($this->reservesList->getArray() as $reserve) {
            //$vehicleModel = $this->modelService->readModelById($vehicle->getModel());
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="updatedReserveID" value="{$reserve->getId()}" required></td>
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
        $html .= <<<EOS
            </table>
            </div>
            <div>
                <button type="submit" name="update"> Actualizar </button>
            </div>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        if(!isset($datos['updatedReserveID']))
            $this->errores[] = 'Debe seleccionar una reserva.';

        if (count($this->errores) === 0) { 
            $this->changeUlrRedireccion("{$this->urlRedireccion}?id={$datos['updatedReserveID']}");
            header("Location: {$this->urlRedireccion}");
        }
    }
}