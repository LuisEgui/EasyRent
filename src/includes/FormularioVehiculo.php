<?php

require_once __DIR__.'\Formulario.php';
require_once __DIR__.'\Vehiculo.php';

class FormularioVehiculo extends Formulario {
    
    public function __construct() {
        parent::__construct('formVehiculo', ['urlRedireccion' => 'annadido.php']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['vin', 'licensePlate', 'model', 'fuelType', 'seatCount', 'state'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Crea vehiculo</legend>
            <div>
                <label for="vin">Vehicle Identification Number: </label>
                <input type="text" id="vin" name="vin" />
                {$erroresCampos['vin']}
            </div>
            <div>
                <label for="licPl">License Plate: </label>
                <input type="text" id="licPl" name="licensePlate" />
                {$erroresCampos['licensePlate']}
            </div>
            <div>
                <label for="mod">Model: </label>
                <input type="text" id="mod" name="model"/>
                {$erroresCampos['model']}
            </div>
            <div>
                <label for="fuelT">Fuel Type: </label>
                <select id="fuelT" name="fuelType">
                    <option value="diesel">Diesel</option>
                    <option value="electric-hybrid">Electric-hybrid</option>
                    <option value="electric">Electric</option>
                    <option value="petrol">Petrol</option>
                    <option value="plug-in-hybrid">Plug-in-hybrid</option>
                </select>
                {$erroresCampos['fuelType']}
            </div>
            <div>
                <label for="seatC">Seat Count: </label>
                <input type="number" id="seatC" name="seatCount" value="5" min="2" max="9" />
                {$erroresCampos['seatCount']}
            </div>
            <div>
                <input type="submit" name="crearVehiculo" value="Crear vehiculo">
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $vin = htmlspecialchars(strip_tags(trim($datos['vin'] ?? '')));
        $vin = filter_var($vin, FILTER_SANITIZE_NUMBER_INT);

        if ( ! $vin || empty($vin) ) {
            $this->errores['vin'] = 'El VIN del vehiculo no es correcto o esta vacio';
        }
        
        $licensePlate = strip_tags(trim($datos['licensePlate'] ?? ''));
        $licensePlate = filter_var($licensePlate, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $licensePlate || empty($licensePlate) ) {
            $this->errores['licensePlate'] = 'La matricula del vehiculo no es correcto o esta vacio';
        }

        $model = htmlspecialchars(strip_tags(trim($datos['model'] ?? '')));
        $model = filter_var($model, FILTER_SANITIZE_NUMBER_INT);

        if ( ! $model || empty($model) ) {
            $this->errores['model'] = 'El modelo del vehiculo no es correcto o esta vacio';
        }

        /*$fuelType = htmlspecialchars(strip_tags(trim($fuelType['vin'] ?? ''));
        $fuelType = filter_var($fuelType, FILTER_SANITIZE_NUMBER_INT);

        if ( ! $fuelType || empty($vin) ) {
            $this->errores['vin'] = 'El VIN del vehiculo no es correcto o esta vacio';
        }*/

        $seatCount = htmlspecialchars(strip_tags(trim($datos['seatCount'] ?? '')));
        $seatCount = filter_var($seatCount, FILTER_SANITIZE_NUMBER_INT);

        if ( ! $seatCount || empty($seatCount) ) {
            $this->errores['seatCount'] = 'El numero de asientos del vehiculo no es correcto o esta vacio';
        }

        /*$state = htmlspecialchars(strip_tags(trim($datos['vin'] ?? ''));
        $vin = filter_var($vin, FILTER_SANITIZE_NUMBER_INT);

        if ( ! $vin || empty($vin) ) {
            $this->errores['vin'] = 'El VIN del vehiculo no es correcto o esta vacio';
        }*/
        
        if (count($this->errores) === 0) {
            $vehiculo = Vehiculo::crea($vin, $licensePlate, $model, $fuelType, $seatCount);
            $usuario = Vehiculo::inserta($vehiculo);
        
            if (!$vehiculo) {
                $this->errores[] = "El vehiculo no se ha podido introducir en la base de datos";
            } else {
                header("Location: {$this->urlRedireccion}");
            }
        }
    }
}
