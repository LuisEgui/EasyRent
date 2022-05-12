<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;

class FormularioActualizarReturnLocationReserva extends Formulario {

    private $reserveService;

    public function __construct() {
        parent::__construct('formUpdateReserveReturnLocation', ['urlRedireccion' => 'index.php']);
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
            <legend>Actualizar localizacion de devolucion</legend>
            <div>
                <label for="returnLocation">Lugar devolucion:</label>
                <select id="returnLocation" name="returnLocation">
                    <option value="Madrid">Madrid</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Sevilla">Sevilla</option>
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
        $reserve = $datos['returnLocation'];
        if ($this->reserveService->updateReserveReturnLocation($_GET["id"], $reserve))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the return location of this reserve!";
    }
}
