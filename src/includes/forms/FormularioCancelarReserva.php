<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;

class FormularioCancelarReserva extends Formulario {

    private $reserveService;

    public function __construct() {
        parent::__construct('formCancelReserve', ['urlRedireccion' => '../index.php']);
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
            <legend>Cancelar reserva</legend>
            <div>
                <p>¿Estás seguro de que quieres cancelar esta reserva?</p>
            </div>
            <div>
                <label><input type="submit" name="confirm" value="Si"></label>
                <label><input type="submit" name="confirm" value="No"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $result = $datos['confirm'];

        if ($result == 'Si') {
            if ($this->reserveService->deleteReserve($_GET["id"]))
                header("Location: {$this->urlRedireccion}");
            else
                $this->errores[] = "Can't delete this reserve!";
        }
    }

}
