<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;

class FormularioActualizarPickupTimeReserva extends Formulario {

    private $reserveService;

    public function __construct() {
        parent::__construct('formUpdateReservePickupTime', ['urlRedireccion' => '../index.php']);
        $this->reserveService = ReserveService::getInstance();
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Actualizar hora de recogida</legend>
            <div>
                <label for="pickupTime">Hora recogida:</label>
                <input type="datetime-local" id="pickupTime"
                name="pickupTime" >
            </div>
            <div>
                <label><input type="submit" name="update" value="Actualizar"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario(&$datos) {
        $reservePT = $datos['pickupTime'];
        if ($this->reserveService->updateReservePickupTime($_GET["id"], $reservePT))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the pickup time of this reserve! Car is not available that date";
    }
}
