<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;
use easyrent\includes\service\VehicleService;

class FormularioBuscarVehiculo extends Formulario {

    private $reserveService;

    private $vehicleService;
    
    public function __construct() {
        parent::__construct('formSearchCars', ['urlRedireccion' => 'mostrarVehiculos.php']);
        $this->vehicleService = VehicleService::getInstance();
        $this->reserveService = ReserveService::getInstance();
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);    }
    
    protected function generaCamposFormulario(&$datos) {
       // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="buscadorVehiculo">
            <div>
                <label for="pickupLocation">Lugar recogida:</label>
                <select id="pickupLocation" name="pickupLocation">
                    <option value="Madrid">Madrid</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Zaragoza">Zaragoza</option>
                    <option value="Oviedo">Oviedo</option>
                    <option value="Palma de Mallorca">Palma de Mallorca</option>
                    <option value="Santa Cruz de Tenerife">Santa Cruz de Tenerife</option>
                    <option value="Santander">Santander</option>
                    <option value="Toledo">Toledo</option>
                    <option value="Valladolid">Valladolid</option>
                    <option value="Merida">Merida</option>
                    <option value="Santiago de Compostela">Santiago de Compostela</option>
                    <option value="Logroño">Logroño</option>
                    <option value="Murcia">Murcia</option>
                    <option value="Pamplona">Pamplona</option>
                    <option value="Valencia">Valencia</option>
                    <option value="Vitoria">Vitoria</option>
                </select>
            </div>
            <div>
                <label for="pickupDate">Recogida: </label>
                <input type="date" id="pickupDate" name="pickupDate" />
            </div>
            <div>
                <label for="returnDate">Devolución: </label>
                <input type="date" id="returnDate" name="returnDate"/>
            </div>
            <div>
                <input type="submit" name="buscar" value="buscar"/>
            </div>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        
        if (count($this->errores) === 0) { 
            $this->changeUlrRedireccion("{$this->urlRedireccion}?location={$datos['pickupLocation']}");

            if(isset($datos['returnDate']) && isset($datos['pickupDate'])) $this->changeUlrRedireccion("{$this->urlRedireccion}&rDate={$datos['returnDate']}&pDate={$datos['pickupDate']}");
            else {
                if(isset($datos['pickupDate'])) $this->changeUlrRedireccion("{$this->urlRedireccion}&pDate={$datos['pickupDate']}");
                if(isset($datos['returnDate'])) $this->changeUlrRedireccion("{$this->urlRedireccion}&rDate={$datos['returnDate']}");
            }
            
            header("Location: {$this->urlRedireccion}");
        }
    }
    
}