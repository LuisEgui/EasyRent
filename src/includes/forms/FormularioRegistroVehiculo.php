<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ModelService;
use easyrent\includes\service\VehicleService;

class FormularioRegistroVehiculo extends Formulario {

    private $vehicleService;
    private $modelService;

    public function __construct() {
        parent::__construct('formRegisterVehicle', ['urlRedireccion' => 'vehiclesAdmin.php']);
        $this->vehicleService = VehicleService::getInstance();
        $this->modelService = ModelService::getInstance();
    }

    private function generateModelSelector($name, $tipoSeleccionado=null)
    {
        $models = $this->modelService->readAllModels();
        $html = '';
        if(!empty($models)){
            $html .= "<label for=\"modelList\">Modelo:</label>
                <select id=\"modelList\" name=\"{$name}\">";
            foreach($models as $model) {
                $html .= "<option ";
                $selected='';
                if ($tipoSeleccionado && $model->getId() == $tipoSeleccionado)
                    $selected='selected';
                $html .= "value=\"{$model->getId()}\" {$selected}>{$model->getBrand()} {$model->getModel()} {$model->getSubmodel()}</option>";
            }
            $html .= "</select>";
        }
        $html .= '';

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $vin = $datos['vin'] ?? '';
        $licensePlate = $datos['licensePlate'] ?? '';
        $model = $datos['model'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['vin', 'licensePlate', 'model'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta

        $modelSelector = $this->generateModelSelector('model', $model);

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
                $modelSelector{$erroresCampos['model']}
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
            $this->errores['licensePlate'] = 'Formato de la matricula inválido! Debe contener 4 numeros y entre 1 y 3 letras mayusculas no vocales';

        $model = trim($datos['model'] ?? '');
        $model = filter_var($model, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $model || empty($model))
            $this->errores['model'] = 'El modelo del vehiculo no puede estar vacío';

        if( !is_numeric($model))
            $this->errores['model'] = 'Formato del modelo inválido! Debe ser un numero';

        if (!self::validModel($model))
            $this->errores['model'] = "El modelo seleccionado no se encuentra disponible en la base de datos.";

        if (count($this->errores) === 0) {
            $vehicle = $this->vehicleService->createVehicle($vin, $licensePlate, $model, 'available');

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

    protected function validModel($model) {
        if($this->modelService->readModelById($model) === null) 
            return false;
        return true;
    }

}
