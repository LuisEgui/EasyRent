<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\VehicleService;

class FormularioRegistroVehiculo extends Formulario {

    private $vehicleService;

    const AVAILABLE = 'available', UNAVAILABLE = 'unavailable', RESERVED = 'reserved';
    const STATES = [self::AVAILABLE => 'Disponible', self::UNAVAILABLE => 'No disponible', self::RESERVED => 'Reservado'];

    const DIESEL = 'diesel', ELECTRIC_HYBRID = 'electric-hybrid', ELECTRIC = 'electric', PETROL = 'petrol', PLUG_IN_HYBRID = 'plug-in-hybrid';
    const FUELTYPES = [ self::DIESEL => 'Diesel', self::ELECTRIC_HYBRID => 'Hibrido', self::ELECTRIC => 'Electrico', self::PETROL => 'Gasolina', self::PLUG_IN_HYBRID => 'Hibrido enchufable'];

    public function __construct() {
        parent::__construct('formRegisterVehicle', ['urlRedireccion' => 'admin.php']);
        $this->vehicleService = new VehicleService($GLOBALS['db_vehicle_repository'], $GLOBALS['db_image_repository']);
    }

    private static function generateFuelTypeSelector($name, $tipoSeleccionado=null)
    {
        $html = '';
        foreach(self::FUELTYPES as $clave => $valor) {
            $html .= "<label>";
            $html .= "<input type='radio' name=\"{$name}\" ";
            $selected='';
            if ($tipoSeleccionado && $clave == $tipoSeleccionado)
                $selected='checked';
            $html .= "value=\"{$clave}\" {$selected}>{$valor} </label>";
        }
        $html .= '';

        return $html;
    }

    private static function generateModelSelector($name, $tipoSeleccionado=null)
    {
        //$models[] = $this->vehicleService->getModelsFromDB();
        $models[] = array();
        $html = '';
        foreach($models as $clave => $valor) {
            $html .= "<label>";
            $html .= "<input type='radio' name=\"{$name}\" ";
            $selected='';
            if ($tipoSeleccionado && $clave == $tipoSeleccionado)
                $selected='checked';
            $html .= "value=\"{$clave}\" {$selected}>{$valor} </label>";
        }
        $html .= '';

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $vin = $datos['vin'] ?? '';
        $licensePlate = $datos['licensePlate'] ?? '';
        $model = $datos['model'] ?? '';
        $fuelType = $datos['fuelType'] ?? self::DIESEL;
        $seatCount = $datos['seatCount'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['vin', 'licensePlate', 'model', 'fuelType', 'seatCount'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta

        $fuelTypeSelector = self::generateFuelTypeSelector('fuelType', $fuelType);
        //$modelSelector = self::generateModelSelector('model', $model);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="vin">VIN:</label>
                <input id="vin" type="text" name="vin" value="$vin" />{$erroresCampos['vin']}
            </div>
            <div>
                <label for="licensePlate">Matricula:</label>
                <input id="licensePlate" type="text" name="licensePlate" value="$licensePlate" />{$erroresCampos['licensePlate']}
            </div>
            <div>
                <label for="model">Modelo:</label>
                <input id="model" type="text" name="model" value="$model" />{$erroresCampos['model']}
            </div>
            <div>
                <label>Tipo de combustible: </label>
                $fuelTypeSelector{$erroresCampos['fuelType']}
            </div>
            <div>
                <label for="seatCount">Numero de asientos:</label>
                <input id="seatCount" type="text" name="seatCount" value="$seatCount" />{$erroresCampos['seatCount']}
            </div>
            <div>
                <button type="submit" name="register"> Registrar </button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $vin = trim($datos['vin'] ?? '');
        $vin = filter_var($vin, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $vin || empty($vin))
            $this->errores['vin'] = 'El VIN del vehiculo no puede estar vacío';

        if( !self::validateVIN($vin))
            $this->errores['vin'] = 'Formato de VIN inválido! Debe contener 6 caracteres numericos';

        $licensePlate = trim($datos['licensePlate'] ?? '');
        $licensePlate = filter_var($licensePlate, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $licensePlate || empty($licensePlate) )
            $this->errores['licensePlate'] = 'La matricula no puede estar vacia.';

        if( !self::validateLicensePlate($licensePlate))
            $this->errores['licensePlate'] = 'Formato de la matricula inválido! Debe contener 4 numeros y entre 3 letras';

        $model = trim($datos['model'] ?? '');
        $model = filter_var($model, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $model || empty($model))
            $this->errores['model'] = 'El modelo del vehiculo no puede estar vacío';

        if( !is_numeric($model))
            $this->errores['model'] = 'Formato del modelo inválido! Debe ser un numero';

        $fuelType = trim($datos['fuelType'] ?? '');
        $fuelType = filter_var($fuelType, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$fuelType || empty($fuelType))
            $this->errores['fuelType'] = 'El tipo de combustible no puede estar vacío.';

        if (!self::validFuelType($fuelType))
            $this->errores['fuelType'] = "El tipo de combustible no es válido. Introduce uno de los siguientes: 'diesel', 'electric-hybrid', 'electric', 'petrol', 'plug-in-hybrid'.";

        $seatCount = trim($datos['seatCount'] ?? '');
        $seatCount = filter_var($seatCount, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $seatCount || empty($seatCount))
            $this->errores['seatCount'] = 'El numero de asientos del vehiculo no puede estar vacío';

        if ( !is_numeric($seatCount))
            $this->errores['seatCount'] = 'Formato del numero de asientos inválido! Debe ser un numero.';

        if ($seatCount < 2 || $seatCount > 9)
            $this->errores['seatCount'] = 'Formato del numero de asientos inválido! Debe ser un numero entre el 2 y el 9';

        if (count($this->errores) === 0) {
            $vehicle = $this->vehicleService->createVehicle($vin, $licensePlate, $model, $fuelType, $seatCount, self::AVAILABLE);

            if (!$vehicle)
                $this->errores[] = "Vehicle already exists!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validateVIN($vin) {
        $pattern = '/^[0-9]{6}$/';
        return preg_match($pattern, $vin);
    }

    protected function validateLicensePlate($licensePlate) {
        $pattern = '/^[0-9]{4}-(?!.*(LL|CH))[BCDFGHJKLMNPRSTVWXYZ]{1,3}$/';
        return preg_match($pattern, $licensePlate);
    }

    protected function validFuelType($fuelType = array()) {
        $defaultRoles = array('diesel', 'electric-hybrid', 'electric', 'petrol', 'plug-in-hybrid');
        return in_array($fuelType, $defaultRoles);
    }

}
