<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;
use easyrent\includes\service\VehicleService;

class FormularioActualizarVehiculoReserva extends Formulario {

    private $reserveService;

    private $vehicleService;

    public function __construct() {
        parent::__construct('formUpdateReserveVehicle', ['urlRedireccion' => RUTA_APP.'/index.php']);
        $this->vehicleService = VehicleService::getInstance();
        $this->reserveService = ReserveService::getInstance();
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {

        $vehiculos = $this->vehicleService->readAllVehicles();
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Actualizar Vehicle</legend>
            <div>
                <label for="vehicle">Vehiculo:</label>
                <select id="vehicle" name="vehicle">
        EOF;
        if(count($vehiculos) === 0) $html .= 0;
        for ($i = 0; $i < count($vehiculos); $i++) {
            //hacer algo para que vehiculos reservados no salgan
            $html .= <<<EOF
                <option value="
            EOF;
            $html .= $vehiculos[$i]->getVin();
            $html .= <<<EOF
                ">
            EOF;
            $html .= $vehiculos[$i]->getVin();
            $html .= <<<EOF
                </option>
            EOF;
        }
        $html .= <<<EOF
                </select>
            </div>
            <div>
                <label><input type="submit" name="update" value="Actualizar"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario(&$datos) {
        $reserve = $datos['vehicle'];
        if ($this->reserveService->updateReserveVehicle($_GET["id"], $reserve))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the vehicle of this reserve! There must be an incompatibility of dates or times";
    }
}
