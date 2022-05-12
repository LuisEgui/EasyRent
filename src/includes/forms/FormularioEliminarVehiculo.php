<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\DamageService;
use easyrent\includes\service\ModelService;
use easyrent\includes\service\VehicleService;
use easyrent\includes\service\ReserveService;
use easyrent\includes\service\lists\VehicleList;

class FormularioEliminarVehiculo extends Formulario {

    private $vehicleService;

    private $modelService;

    private $damageService;

    private $reserveService;

    private $vehiclesList;

    private $orderVehiclesBy;

    public function __construct($orderByFunction) {
        parent::__construct('formDeleteVehicle', ['urlRedireccion' => 'vehiclesAdmin.php']);
        $this->vehicleService = VehicleService::getInstance();
        $this->modelService = ModelService::getInstance();
        $this->damageService = DamageService::getInstance();
        $this->reserveService = ReserveService::getInstance();
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
                    <td><input type="radio" name="deletedVehicleVIN" value="{$vehicle->getVin()}" required></td>
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
                <button type="submit" name="delete"> Eliminar </button>
            </div>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        if(!isset($datos['deletedVehicleVIN']))
            $this->errores[] = 'Debe seleccionar un vehiculo.';

        $damages = $this->damageService->readDamagesByVehicle($datos['deletedVehicleVIN']);
        if(!empty($damages))
            $this->errores[] = 'Existen incidentes asociados al vehiculo que desea eliminar. Por favor, elimine en primer lugar dichos incidentes y, posteriormente, el vehiculo.';

        $reserves = $this->reserveService->readReservesByVehicle($datos['deletedVehicleVIN']);
        if(!empty($reserves))
            $this->errores[] = 'Existen reservas asociadas al vehiculo que desea eliminar. Por favor, elimine en primer lugar dichas reservas y, posteriormente, el vehiculo.';

        if (count($this->errores) === 0) {
            $result = $this->vehicleService->deleteVehicleByVin($datos['deletedVehicleVIN']);
            if (!$result)
                $this->errores[] = "Vehicle doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}
