<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/VehicleService.php';

class FormularioEliminarVehiculo extends Formulario {

    private $vehicleService;

    public function __construct() {
        parent::__construct('formDeleteVehicle', ['urlRedireccion' => 'admin.php']);
        $this->vehicleService = new VehicleService($GLOBALS['db_vehicle_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista

        // Se leen todos los vehiculos de la base de datos
        $vehicles = $this->vehicleService->readAllVehicles();

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>VIN</th>
                    <th>Matricula</th>
                    <th>Modelo</th>
                    <th>Tipo de combustible</th>
                    <th>Numero de asientos</th>
                    <th>Estado</th>
                </tr>
        EOS;

        foreach($vehicles as $vehicle) {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="deletedVehicleVIN" value="{$vehicle->getVin()} required"></td>
                    <td>{$vehicle->getVin()}</td>
                    <td>{$vehicle->getLicensePlate()}</td>
                    <td>{$vehicle->getModel()}</td>
                    <td>{$vehicle->getFuelType()}</td>
                    <td>{$vehicle->getSeatCount()}</td>
                    <td>{$vehicle->getState()}</td>
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

        if (count($this->errores) === 0) {
            $result = $this->vehicleService->deleteVehicle($datos['deletedVehicleVIN']);
            if (!$result)
                $this->errores[] = "Vehicle doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}