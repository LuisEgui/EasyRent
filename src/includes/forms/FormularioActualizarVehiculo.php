<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\VehicleService;
use easyrent\includes\service\ModelService;
use easyrent\includes\persistance\lists\VehicleList;

class FormularioActualizarVehiculo extends Formulario {

    private $vehicleService;

    private $modelService;

    private $vehiclesList;

    private $orderVehiclesBy;

    public function __construct($orderByFunction) {
        parent::__construct('formUpdateVehicle', ['urlRedireccion' => 'actualizarDatosVehiculo.php']);
        $this->vehicleService = VehicleService::getInstance();
        $this->modelService = ModelService::getInstance();
        $this->vehiclesList = new VehicleList();
        if(isset($orderByFunction)){
            $this->orderVehiclesBy = $orderByFunction;
        }
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista

        // Se leen todos los vehiculos de la base de datos y se almacenan en un array de la instancia de la clase VehicleList
        $this->vehiclesList->setArray($this->vehicleService->readAllVehicles());
        if(isset($this->orderVehiclesBy)){
            $this->vehiclesList->orderBy($this->orderVehiclesBy);
        }

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>VIN</th>
                    <th>Matricula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Submodelo</th>
                    <th>Ubicacion</th>
                    <th>Estado</th>
                    <th>Fecha de modificación</th>
                </tr>
        EOS;

        foreach($this->vehiclesList->getArray() as $vehicle) {
            $vehicleModel = $this->modelService->readModelById($vehicle->getModel());
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="updatedVehicleVIN" value="{$vehicle->getVin()}" required></td>
                    <td>{$vehicle->getVin()}</td>
                    <td>{$vehicle->getLicensePlate()}</td>
                    <td>{$vehicleModel->getBrand()}</td>
                    <td>{$vehicleModel->getModel()}</td>
                    <td>{$vehicleModel->getSubmodel()}</td>
                    <td>{$vehicle->getLocation()}</td>
                    <td>{$vehicle->getState()}</td>
                    <td>{$vehicle->getTimeStamp()}</td>
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
        //$this->urlDireccion = "{$this->urlRedireccion}?vinVehicleToUpdate={$datos['updatedVehicleVIN']}";
        //echo "{$this->urlRedireccion}";
        if(!isset($datos['updatedVehicleVIN']))
            $this->errores[] = 'Debe seleccionar un vehiculo.';

        if (count($this->errores) === 0) { 
            $this->changeUlrRedireccion("{$this->urlRedireccion}?vinVehicleToUpdate={$datos['updatedVehicleVIN']}");
            header("Location: {$this->urlRedireccion}");
        }
    }
}