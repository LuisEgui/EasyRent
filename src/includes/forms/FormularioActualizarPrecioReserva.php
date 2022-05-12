<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;

class FormularioActualizarPrecioReserva extends Formulario {

    private $reserveService;

    public function __construct() {
        parent::__construct('formUpdateReservePrice', ['urlRedireccion' => RUTA_APP.'/index.php']);
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
                <label for="price">Tarifa:</label>
                <select id="price" name="price">
                    <option value="20">Tarifa normal 20€/dia</option>
                    <option value="35">Gasolina incluida 35€/dia</option>
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
        $reserve = $datos['price'];
        if ($this->reserveService->updateReservePrice($_GET["id"], $reserve))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the price of this reserve!";
    }
}
