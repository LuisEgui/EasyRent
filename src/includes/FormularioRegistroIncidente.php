<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/DamageService.php';
require_once __DIR__.'/VehicleService.php';
require_once __DIR__.'/UserService.php';

class FormularioRegistroIncidente extends Formulario {

    private $damageService;
    private $vehicleService;
    private $userService;
    const MINOR = 'minor', MODERATE = 'moderate', SEVERE = 'severe';
    const TYPE = [self::MINOR => 'minor', self::MODERATE => 'moderate', self::SEVERE => 'severe'];
    const BRAKES = 'brakes', CONTROLS = 'controls', ENGINE = 'engine', FRONT = 'front', GENERAL = 'general', INTERIOR = 'interior', LEFT = 'left', RIGHT = 'right', REAR = 'rear', ROOF = 'roof', TRUNK = 'trunk', UNDERBODY = 'underbody', WHEELS = 'wheels';
    const AREA = [self::BRAKES => 'brakes', self::CONTROLS => 'controls', self::ENGINE => 'engine', self::FRONT => 'front', self::GENERAL => 'general', self::INTERIOR => 'interior', self::LEFT => 'left', self::RIGHT => 'right', self::REAR => 'rear', self::ROOF => 'roof', self::TRUNK => 'trunk', self::UNDERBODY => 'underbody', self::WHEELS => 'wheels'];
    
    public function __construct() {
        parent::__construct('formRegisterDamage', ['urlRedireccion' => 'incidente.php']);
        $this->damageService = new DamageService($GLOBALS['db_damage_repository']);
        $this->vehicleService = new VehicleService($GLOBALS['db_vehicle_repository'], $GLOBALS['db_image_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
        
    }

    private static function generateTypeSelector($name, $tipoSeleccionado=null)
    {
        $html = '';
        foreach(self::TYPE as $clave => $valor) {
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

    private static function generateAreaSelector($name, $tipoSeleccionado=null)
    {
        $html = '';
        foreach(self::AREA as $clave => $valor) {
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
        $vehicles = $this->vehicleService->readAllVehicles();
        // Se reutiliza el email introducido previamente o se deja en blanco
        $type = $datos['type'] ?? self::MINOR;
        $area = $datos['area'] ?? self::GENERAL;
        $title = $datos['title'] ?? '';
        $description = $datos['description'] ?? '';
        $vehicle = $datos['vehicle'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['user', 'vehicle', 'type', 'title', 'description', 'evidenceDamage', 'area'], $this->errores, 'span', array('class' => 'error'));
        $typeSelector = self::generateTypeSelector('type', $type);
        $areaSelector = self::generateAreaSelector('area', $area);

        

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOS
                   $htmlErroresGlobales
                    <fieldset>
            <legend>Vehículo, Título, Descripción, Imagen, Tipo y Área</legend>
            <div>
                <label>Vehículo: </label>
             </div>
            EOS;
            $html = <<<EOS
            <div>
            <table>
            <tr>
                <th></th>
                <th>VIN</th>
                <th>Matricula</th>
                <th>Modelo</th>
                <th>Tipo de combustible</th>
                <th>Numero de asientos</th>
                <th>Estado</th>
            </tr>
            EOS;
            foreach($vehicles as $vehicle) {
                $html .= <<<EOS
                    <tr>
                        <td><input type="radio" name="vehicle" value="{$vehicle->getVin()}"></td>
                        <td>{$vehicle->getVin()}</td>
                        <td>{$vehicle->getLicensePlate()}</td>
                        <td>{$vehicle->getModel()}</td>
                        <td>{$vehicle->getFuelType()}</td>
                        <td>{$vehicle->getSeatCount()}</td>
                        <td>{$vehicle->getState()}</td>
                    </tr>
                EOS;
            }
            $html .= <<<EOS
            </table>
            </div>
            <div>
                <label for="title">Título:</label>
                <input id="title" type="text" name="title" value="$title" />{$erroresCampos['title']}
            </div>
            <div>
                <label for="description">Descripción:</label>
                <input id="description" type="text" name="description" value="$description" />{$erroresCampos['description']}
            </div>
            <div>
                <label for="evidenceDamage">Imagen:</label>
            </div>
            <div>
                <label>Tipo: </label>
                $typeSelector{$erroresCampos['type']}
            </div>
            <div>
                <label>Area: </label>
                $areaSelector{$erroresCampos['area']}
            </div>
            <div>
                <button type="submit" name="register">Registrarse</button>
            </div>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $title = trim($datos['title']);
        $description = trim($datos['description']);

        if ( ! $title || empty($title))
            $this->errores['title'] = 'El título de la incidencia no puede estar vacío';
        

        $useremail = $_SESSION['email'];
        $user = $this->userService->readUserByEmail($useremail);
        
        $vehicle = trim($datos['vehicle'] ?? '');
        $vehicle = filter_var($vehicle, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$vehicle || empty($vehicle))
            $this->errores['vehicle'] = 'El vehículo no puede estar vacío.';
        
        $area = trim($datos['area'] ?? '');
        $area = filter_var($area, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$area || empty($area))
            $this->errores['area'] = 'El area no puede estar vacía.';

        if (!self::validArea($area))
            $this->errores['area'] = "El area no es válida. Introduce una de las posibles";

        $type = trim($datos['type'] ?? '');
        $type = filter_var($type, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$type || empty($type))
            $this->errores['type'] = 'El tipo no puede estar vacío.';

        if (!self::validType($type))
            $this->errores['type'] = "El tipo no es válido. Introduce uno de los posibles";
        
        if (count($this->errores) === 0) {
            $damage = $this->damageService->createDamage($vehicle, $user->getId(), $title, $description, NULL, $area, $type, false);
        
            if (!$damage)
                $this->errores[] = "Error al crear la incidencia";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }


    protected function validArea($area = array()) {
        $defaultRoles = array('brakes', 'controls',  'engine', 'front', 'general', 'interior', 'left', 'right', 'rear', 'roof','trunk', 'underbody', 'wheels');
        return in_array($area, $defaultRoles);
    }

    protected function validType($type = array()) {
        $defaultRoles = array('minor', 'severe',  'moderate');
        return in_array($type, $defaultRoles);
    }
    
}