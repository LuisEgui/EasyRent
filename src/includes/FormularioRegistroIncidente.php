<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/DamageService.php';
require_once __DIR__.'/VehicleService.php';
require_once __DIR__.'/ModelService.php';
require_once __DIR__.'/UserService.php';
require_once __DIR__.'/User.php';

class FormularioRegistroIncidente extends Formulario {

    private $damageService;

    private $vehicleService;

    private $modelService;

    private $userService;

    /*const MINOR = 'minor', MODERATE = 'moderate', SEVERE = 'severe';
    const TYPE = [self::MINOR => 'minor', self::MODERATE => 'moderate', self::SEVERE => 'severe'];
    
    const BRAKES = 'brakes', CONTROLS = 'controls', ENGINE = 'engine', FRONT = 'front', GENERAL = 'general', INTERIOR = 'interior', LEFT = 'left', RIGHT = 'right', REAR = 'rear', ROOF = 'roof', TRUNK = 'trunk', UNDERBODY = 'underbody', WHEELS = 'wheels';
    const AREA = [self::BRAKES => 'brakes', self::CONTROLS => 'controls', self::ENGINE => 'engine', self::FRONT => 'front', self::GENERAL => 'general', self::INTERIOR => 'interior', self::LEFT => 'left', self::RIGHT => 'right', self::REAR => 'rear', self::ROOF => 'roof', self::TRUNK => 'trunk', self::UNDERBODY => 'underbody', self::WHEELS => 'wheels'];
    */

    private const DEFAULTTYPE = ['Minor', 'Moderate', 'Severe'];

    private const DEFAULTAREA = ['Brakes', 'Controls', 'Engine', 'Front', 'General', 'Interior', 'Left', 'Right', 'Rear', 'Roof', 'Trunk', 'Underbody', 'Wheels'];

    public function __construct() {
        parent::__construct('formRegisterDamage', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'incidentesAdmin.php']);
        $this->damageService = DamageService::getInstance();
        $this->vehicleService = VehicleService::getInstance();
        $this->modelService = ModelService::getInstance();
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
        
    }

    private function generateTypeSelector($name, $tipoSeleccionado=null)
    {
        $html = "<label for=\"type\">Tipo de incidencia:</label>
            <select id=\"type\" name=\"{$name}\">";
        foreach(self::DEFAULTTYPE as $type) {
            $html .= "<option ";
            $selected='';
            if ($tipoSeleccionado && $type == $tipoSeleccionado)
                $selected='selected';
            $html .= "value=\"{$type}\" {$selected}>{$type}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    private function generateAreaSelector($name, $tipoSeleccionado=null)
    {
        $html = "<label for=\"area\">Area de incidencia:</label>
            <select id=\"area\" name=\"{$name}\">";
        foreach(self::DEFAULTAREA as $area) {
            $html .= "<option ";
            $selected='';
            if ($tipoSeleccionado && $area == $tipoSeleccionado)
                $selected='selected';
            $html .= "value=\"{$area}\" {$selected}>{$area}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    private function generateVehicleSelector($name, $tipoSeleccionado=null)
    {
        $vehicles = $this->vehicleService->readAllVehicles();
        $html = '';
        if(!empty($vehicles)){
            $html .= "<label for=\"vehicle\">Vehiculo relacionado:</label>
                <select id=\"vehicle\" name=\"{$name}\">";
            foreach($vehicles as $vehicle) {
                $model = $this->modelService->readModelById($vehicle->getModel());
                $html .= "<option ";
                $selected='';
                if ($tipoSeleccionado && $vehicle->getVin() == $tipoSeleccionado)
                    $selected='selected';
                $html .= "value=\"{$vehicle->getVin()}\" {$selected}>Matricula: {$vehicle->getLicensePlate()} | Coche: {$model->getBrand()} {$model->getModel()}</option>";
            }
            $html .= "</select>";
        }
        $html .= '';

        return $html;
    }

    private function generateUserSelector($name, $tipoSeleccionado=null)
    {
        $users = $this->userService->readAllUsersNoAdmin();
        $html = '';
        if(!empty($users)){
            $html .= "<label for=\"usr\">Usuario relacionado:</label>
                <select id=\"usr\" name=\"{$name}\">";
            foreach($users as $user) {
                $html .= "<option ";
                $selected='';
                if ($tipoSeleccionado && $user->getId() == $tipoSeleccionado)
                    $selected='selected';
                $html .= "value=\"{$user->getId()}\" {$selected}>ID: {$user->getId()} | Email: {$user->getEmail()} </option>";
            }
            $html .= "</select>";
        }
        $html .= '';

        return $html;
    }
    
    protected function generaCamposFormulario(&$datos) {
        $vehicles = $this->vehicleService->readAllVehicles();
        // Se reutiliza el email introducido previamente o se deja en blanco
        $type = $datos['type'] ?? '';
        $area = $datos['area'] ?? '';
        $title = $datos['title'] ?? '';
        $description = $datos['description'] ?? '';
        $vehicle = $datos['vehicle'] ?? '';
        $user = $datos['user'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = $this->generaErroresCampos(['user', 'vehicle', 'type', 'title', 'description', 'archivo', 'area'], $this->errores, 'span', array('class' => 'error'));
        
        $typeSelector = $this->generateTypeSelector('type', $type);
        $areaSelector = $this->generateAreaSelector('area', $area);
        $vehicleSelector = $this->generateVehicleSelector('vehicle', $vehicle);
        $userSelector = $this->generateUserSelector('user', $user);


        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                $userSelector{$erroresCampos['user']}
            </div>
            <div>
                $vehicleSelector{$erroresCampos['vehicle']}
            </div>
            <div>
                <label for="tit">Titulo:</label>
                <input id="tit" type="text" name="title" value="$title" />{$erroresCampos['title']}
            </div>
            <div>
                <label for="d">Descripcion:</label>
                <textarea id="d" name="description" placeholder="Describe la incidencia que desea notificar">$description</textarea>{$erroresCampos['description']}
            </div>
            <div>
                $areaSelector{$erroresCampos['area']}
            </div>
            <div>
                $typeSelector{$erroresCampos['type']}
            </div>
            <div>
            <label for="archivo">Archivo: (prueba del incidente) (Máx. 8MB):
                <input type="file" name="archivo" id="archivo"/>
            </label>{$erroresCampos['archivo']}
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

        $title = trim($datos['title']);
        $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $title || empty($title))
            $this->errores['title'] = 'El título de la incidencia no puede estar vacío';

        $description = trim($datos['description']);
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $description || empty($description))
            $this->errores['description'] = 'La descripcion de la incidencia no puede estar vacío';
        
        $user = trim($datos['user']);
        $user = filter_var($user, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $user || empty($user))
            $this->errores['user'] = 'La usuario relacionado con la incidencia no puede estar vacío';
        
        if (!self::validUser($user))
            $this->errores['user'] = "El usuario relacionado con la incidencia no coincide con ninguno de los existentes. Introduce uno de los posibles";
        
        
        $vehicle = trim($datos['vehicle'] ?? '');
        $vehicle = filter_var($vehicle, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$vehicle || empty($vehicle))
            $this->errores['vehicle'] = 'El vehículo relacionado con la incidenciano puede estar vacío.';

        if (!self::validVehicle($vehicle))
            $this->errores['vehicle'] = "El vehiculo relacionado con la incidencia no coincide con ninguno de los existentes. Introduce uno de los posibles";
        
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
        
        //Procesar la imagen del incidente:

        // Verificamos que la subida ha sido correcta
        $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if (! $ok) {
            $this->errores['archivo'] = 'Error al subir el archivo. Es necesario subir una foto del incidente para registrarlo.';
            return;
        }

        $nombre = $_FILES['archivo']['name'];

        /* 1.a) Valida el nombre del archivo */
        $ok = self::checkFileUploadedName($nombre) && $this->checkFileUploadedLength($nombre);

        /* 1.b) Sanitiza el nombre del archivo (elimina los caracteres que molestan)
        $ok = self::sanitize_file_uploaded_name($nombre);
        */

        /* 1.c) Utilizar un id de la base de datos como nombre de archivo */
        // Vamos a optar por esta opción que es la que se implementa más adelante

        /* 2. comprueba si la extensión está permitida */
        $extension = pathinfo($nombre, PATHINFO_EXTENSION);
        $ok = $ok && in_array($extension, self::ALLOWED_EXTENSIONS);

        /* 3. comprueba el tipo mime del archivo corresponde a una imagen image/* */
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['archivo']['tmp_name']);
        $ok = preg_match('/image\/*./', $mimeType);

        if (!$ok) {
            $this->errores['archivo'] = 'El archivo tiene un nombre o tipo no soportado';
        }

        if (count($this->errores) > 0) {
            return;
        }

        $tmp_name = $_FILES['archivo']['tmp_name'];

        $path = $nombre;
        $image = new Image(null, $path, $mimeType);
        $imagenSubidaEnElServidor = $this->damageService->saveImage($image);
        $fichero = "{$imagenSubidaEnElServidor->getId()}-{$imagenSubidaEnElServidor->getPath()}";
        $ruta = implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)).'\img\damage', $fichero]);

        if (!move_uploaded_file($tmp_name, $ruta)) {
            $this->errores['archivo'] = 'Error al mover el archivo';
        }

        if (count($this->errores) === 0) {
            $damage = $this->damageService->createDamage($vehicle, $user, $title, $description, $imagenSubidaEnElServidor->getId(), $area, $type);
        
            if (!$damage)
                $this->errores[] = "Error al crear la incidencia";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validArea($area = array()) {
        return in_array($area, self::DEFAULTAREA);
    }

    protected function validType($type = array()) {
        return in_array($type, self::DEFAULTTYPE);
    }
    
    protected function validUser($user) {
        $usersInDatabase = $this->userService->readAllUsersIDNoAdmin();
        return in_array($user, $usersInDatabase);
    }

    protected function validVehicle($vehicle) {
        $vehiclesInDatabase = $this->vehicleService->readAllVehiclesVIN();
        return in_array($vehicle, $vehiclesInDatabase);
    }

    /**
     * Check $_FILES[][name]
     *
     * @param  (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     * @See    http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private static function checkFileUploadedName($filename)
    {
        return mb_ereg_match('/^[0-9A-Z-_\.]+$/i', $filename) == 1;
    }

    /**
     * Sanitize $_FILES[][name]. Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     *
     * If you don't need to handle multi-byte characters you can use preg_replace
     * rather than mb_ereg_replace.
     *
     * @param  (string) $filename - Uploaded file name.
     * @author Sean Vieira
     * @see    http://stackoverflow.com/a/2021729
     */
    private static function sanitizeFileUploadedName($filename)
    {
        /**
         * Remove anything which isn't a word, whitespace, number
         * or any of the following caracters -_~,;[]().
         * If you don't need to handle multi-byte characters
         * you can use preg_replace rather than mb_ereg_replace
         * Thanks @Łukasz Rysiak!
         */
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        // Remove any runs of periods (thanks falstro!)
        return mb_ereg_replace("([\.]{2,})", '', $newName);
    }

    /**
     * Check $_FILES[][name] length.
     *
     * @param  (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     * @See    http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private function checkFileUploadedLength($filename)
    {
        return mb_strlen($filename, 'UTF-8') < 250;
    }
}