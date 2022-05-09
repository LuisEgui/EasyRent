<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/DamageService.php';
require_once __DIR__.'/VehicleService.php';
require_once __DIR__.'/UserService.php';

class FormularioRegistroIncidente extends Formulario {

    private $damageService;
    private $vehicleService;
    private $userService;
    const  = MINOR = 'minor', MODERATE = 'moderate', SEVERE = 'severe';
    const TYPE = [self::MINOR => 'minor', self::MODERATE => 'moderate', self::SEVERE => 'severe'];
    const  = BRAKES = 'brakes', CONTROLS = 'controls', ENGINE = 'engine', FRONT = 'front', GENERAL = 'general', INTERIOR = 'interior', LEFT = 'left', RIGHT = 'right', REAR = 'rear', ROOF = 'roof', TRUNK = 'trunk', UNDERBODY = 'underbody', WHEELS = 'wheels';
    const AREA = [self::BRAKES => 'brakes', self::CONTROLS => 'controls', self::ENGINE => 'engine', self::FRONT => 'front', self::GENERAL => 'general', self::INTERIOR => 'interior', self::LEFT => 'left', self::REAR => 'rear', self::ROOF => 'roof', self::TRUNK => 'trunk', self::underbody => 'underbody', self::WHEELS => 'wheels'];
    
    public function __construct() {
        parent::__construct('formRegisterDamage', ['urlRedireccion' => 'index.php']);
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

    private static function generateUserSelector($name, $tipoSeleccionado=null)
    {
        $users = $this->userService->readAllUsers();
        foreach($users as $user) {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="{$name}" value="{$user->getId()} required"></td>
                    <td>{$user->getId()}</td>
                </tr>
            EOS;
        }
        return $html;
    }

    private static function generateVehicleSelector($name, $tipoSeleccionado=null)
    {
        $vehicles = $this->vehicleService->readAllVehicles();
        foreach($vehicles as $vehicle) {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="{$name}" value="{$vehicle->getId()} required"></td>
                    <td>{$vehicle->getId()}</td>
                </tr>
            EOS;
        }
        return $html;
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $type = $datos['type'] ?? self::MINOR;
        $area = $datos['area'] ?? self::GENERAL;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['user', 'vehicle', 'type', 'description', 'evidenceDamage', 'area'], $this->errores, 'span', array('class' => 'error'));
        $typeSelector = self::generateTypeSelector('type', $type);
        $areaSelector = self::generateAreaSelector('area', $area);
        $userSelector = self::generateUserSelector('user', $user);
        $vehicleSelector = self::generateVehicleSelector('vehicle', $vehicle);

        

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Usuario, Vehículo, Título, Descripción, Imagen, Tipo y Área</legend>
            <div>
                <label>Usuario: </label>
                $userSelector{$erroresCampos['user']}
            </div>
            <div>
                <label>Vehículo: </label>
                $vehicleSelector{$erroresCampos['vehicle']}
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
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $title = trim($datos['title']);
        $description = trim($datos['description'] ?? '');

        if ( ! $title || empty($title))
            $this->errores['title'] = 'El título de la incidencia no puede estar vacío';
        

        $user = trim($datos['user'] ?? '');
        $user = filter_var($user, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$user || empty($user))
            $this->errores['user'] = 'El usuario no puede estar vacío.';
        
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
            $damage = $this->damageService->createDamage($vehicle, $user, $title, $description, NULL, $area, $type, false);
        
            if (!$damage)
                $this->errores[] = "Error al crear la incidencia";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }


    protected function validArea($area = array()) {
        $defaultRoles = array('brakes', 'controls',  'engine', 'front', 'general', 'interior', 'left', 'right', 'rear', 'roof','trunk', 'underbody', 'wheels');
        return in_array($role, $defaultRoles);
    }

    protected function validType($area = array()) {
        $defaultRoles = array('minor', 'severe',  'moderate');
        return in_array($role, $defaultRoles);
    }
    
}