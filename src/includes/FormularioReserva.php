<?php

require_once __DIR__.'\Formulario.php';
require_once __DIR__.'\Reserva.php';
require_once __DIR__.'\User.php';
require_once __DIR__.'\BD.php';

class FormularioReserva extends Formulario {

    private $reserveService;
    private $userService;
    
    public function __construct() {
        parent::__construct('formReserve', ['urlRedireccion' => 'reservado.php']);
        $this->reserveService = new ReserveService($GLOBALS['db_reserve_repository'], $GLOBALS['db_vehicle_repository'], $GLOBALS['db_user_repository']);
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
            <input type="hidden" name="id" value="
        EOF;
        $html .= $_GET["id"];
        $html .= <<<EOF
            " id="vehicle" />
            <input id="usuario" type="hidden" name="usuario" value="
        EOF;
        $html .= $user->getId();
        $html .= <<<EOF
                "/>
            <div>
                <label for="pickupLocation">Lugar recogida:</label>
                <select id="pickupLocation" name="pickupLocation">
                    <option value="Madrid">Madrid</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Sevilla">Sevilla</option>
                </select>
                {$erroresCampos['localizacion']}
            </div>
            <div>
                <label for="returnLocation">Lugar devolucion:</label>
                <select id="returnLocation" name="returnLocation">
                    <option value="Madrid">Madrid</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Sevilla">Sevilla</option>
                </select>
                {$erroresCampos['localizacion']}
            </div>
            <div>
                <label for="pickupTime">Hora recogida:</label>
                <input type="datetime-local" id="pickupTime"
                name="pickupTime" min="2022-06-19T09:00" max="2022-12-31T14:00">
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="returnTime">Hora devolucion:</label>
                <input type="datetime-local" id="returnTime"
                name="returnTime" min="2022-06-19T09:00" max="2022-12-31T21:00">
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
        $vehicle = $_GET["id"];
        $usuario = $datos['usuario'];
        $state = 0;
        $pickupLocation = $datos['pickupLocation'];
        $returnLocation = $datos['returnLocation']; 
        $pickupTime = $datos['pickupTime'];
        $returnTime = $datos['returnTime'];
        $price = $datos['price'];

        if (count($this->errores) === 0) {
            $reserva = $this->reserveService->createReserve($vehicle, $usuario, $state, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price);
        
            if (!$reserva)
                $this->errores[] = "";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

}