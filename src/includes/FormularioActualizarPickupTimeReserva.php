<?php

require_once RAIZ_APP.'/Formulario.php';
require_once RAIZ_APP.'/ReserveService.php';
require_once RAIZ_APP.'/UserService.php';

class FormularioActualizarPickupTimeReserva extends Formulario {

    private $reserveService;
    
    public function __construct() {
        parent::__construct('formUpdateReservePickupTime', ['urlRedireccion' => 'index.php']);
        $this->reserveService = new ReserveService($GLOBALS['db_reserve_repository'], $GLOBALS['db_vehicle_repository'], $GLOBALS['db_user_repository']);
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
        $reserveRT = $datos['pickupTime']; 
        if ($this->reserveService->updateReserveReturnTime($_GET["id"], $reserveRT))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the pickup time of this reserve! It can't be later than the return time";
    }
}