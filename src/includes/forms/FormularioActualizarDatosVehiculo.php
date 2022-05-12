<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\VehicleService;
use easyrent\includes\persistance\entity\Vehicle;

class FormularioActualizarDatosVehiculo extends Formulario {

    private $vehicleService;

    private $vehicleVinToUpdate;

    private $defaultStates = array('available', 'unavailable', 'reserved');
    private $stateNames = ['available' => 'Disponible', 'unavailable' => 'No disponible', 'reserved' => 'Reservado'];

    public function __construct($vinToUpdate) {
        parent::__construct('formUpdateVehicleData', ['urlRedireccion' => 'vehiclesAdmin.php']);
        $this->vehicleService = VehicleService::getInstance();
        if(isset($vinToUpdate)){
            $this->vehicleVinToUpdate = $vinToUpdate;
        }
    }

    private function generateStateSelector($selectedState)
    {
        $html = "<label for=\"states\">Estado del vehiculo:</label>
                <select id=\"states\" name=\"state\">";
        foreach($this->defaultStates as $state) {
            $html .= "<option ";
            $selected='';
            if ($selectedState && $state == $selectedState)
                $selected='selected';
            $html .= "value=\"{$state}\" {$selected}>{$this->stateNames[$state]}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {

        $vehicle =  $this->vehicleService->readVehicleByVin($this->vehicleVinToUpdate);
        $vehicleLocation = $vehicle->getLocation();
        $vehicleState = $vehicle->getState();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['location'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta

        // Se genra el selector de estados del vehiculo
        $stateSelector = $this->generateStateSelector($vehicleState);

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="vin">Ubicación:</label>
                <input id="vin" type="text" name="location" value="$vehicleLocation" />{$erroresCampos['location']}
            </div>
            <div>
                $stateSelector
            </div>
            <div>
                <button type="submit" name="update"> Actualizar </button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $location = trim($datos['location'] ?? '');
        $location = filter_var($location, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $location || empty($location))
            $this->errores['location'] = 'La ubicación del vehiculo no puede estar vacío';

        $state = trim($datos['state'] ?? '');
        $state = filter_var($state, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $state || empty($state))
            $this->errores['state'] = 'El estado del vehiculo no puede estar vacío';

        if( !self::validateState($state))
            $this->errores['state'] = 'El estado introducido es inválido!';

        if (count($this->errores) === 0) {
            $vehicleBeforeUpdate =  $this->vehicleService->readVehicleByVin($this->vehicleVinToUpdate);
            $licensePlate = $vehicleBeforeUpdate->getLicensePlate();
            $model = $vehicleBeforeUpdate->getModel();
            $vehicle = new Vehicle($this->vehicleVinToUpdate, $licensePlate, $model, $location, $state);
            $this->vehicleService->updateVehicle($vehicle);
            header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validateState($state) {
        return in_array($state, $this->defaultStates);
    }
}