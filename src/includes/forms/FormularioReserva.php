<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ReserveService;
use easyrent\includes\service\UserService;

class FormularioReserva extends Formulario {

    private $reserveService;
    private $userService;

    public function __construct() {
        parent::__construct('formReserve', ['urlRedireccion' => 'reservado.php']);
        $this->reserveService = ReserveService::getInstance();
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['id', 'email', 'localizacion', 'fecha'], $this->errores, 'span', array('class' => 'error'));

        $user = $this->userService->readUserByEmail($_SESSION['email']);
        $id = $user->getId();
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos reserva</legend>
            <input id="vehicle" type="hidden" name="vehicle" value="
        EOF;
        $html .= $_GET["id"];
        $html .= <<<EOF
            "/>
            <input id="usuario" type="hidden" name="usuario" value="
        EOF;
        $html .= $id;
        $html .= <<<EOF
                "/>
            <div>
                <label for="pickupLocation">Lugar recogida:</label>
                <select id="pickupLocation" name="pickupLocation">
                    <option value="
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
         Aeropuerto">
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
                    Aeropuerto</option>
                    <option value="
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
         Estacion de tren">
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
                    Estacion de tren</option>
                </select>
                {$erroresCampos['localizacion']}
            </div>
            <div>
                <label for="returnLocation">Lugar devolucion:</label>
                <select id="returnLocation" name="returnLocation">
                    <option value="
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
         Aeropuerto">
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
                    Aeropuerto</option>
                    <option value="
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
         Estacion de tren">
        EOF;
        $html .= $_GET["location"];
        $html .= <<<EOF
                    Estacion de tren</option>
                </select>
                {$erroresCampos['localizacion']}
            </div>
            <div>
                <label for="pickupTime">Hora recogida:</label>
                <input type="datetime-local" id="pickupTime"
                name="pickupTime" >
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="returnTime">Hora devolucion:</label>
                <input type="datetime-local" id="returnTime"
                name="returnTime">
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="price">Tarifa:</label>
                <select id="price" name="price">
                    <option value="20">Tarifa normal 20€/dia</option>
                    <option value="35">Gasolina incluida 35€/dia</option>
                </select>
                {$erroresCampos['localizacion']}
            </div>
            <div>
                <button type="submit" name="reserve">Reservar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $vehicle = $datos['vehicle'];
        $idusuario = $datos['usuario'];
        $state = 0;
        $pickupLocation = $datos['pickupLocation'];
        $returnLocation = $datos['returnLocation'];
        $pickupTime = $datos['pickupTime'];
        $returnTime = $datos['returnTime'];
        $price = $datos['price'];

        if (count($this->errores) === 0) {
            $reserva = $this->reserveService->createReserve($vehicle, $idusuario, $state, $pickupLocation, $returnLocation,
            $pickupTime, $returnTime, $price);

            if (!$reserva)
                $this->errores[] = "no se ha creado la reserva";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

}
