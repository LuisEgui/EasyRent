<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ModelService;
use easyrent\includes\persistance\entity\Image;
use finfo;

class FormularioRegistroModelo extends Formulario {

    private $modelService;

    private const DEFAULTGEARBOX = ['Manual', 'Automatic', 'Semi-automatic', 'Duplex'];

    private const DEFAULTCATEGORY = ['Coupe', 'Pickup', 'Roadster', 'Sedan', 'Small-car', 'Suv', 'Van'];

    private const DEFAULTFUELTYPE = ['Diesel', 'Electric-hybrid', 'Electric', 'Petrol', 'Plug-in-hybrid'];

    private const ALLOWED_EXTENSIONS = array('jpg','png');

    public function __construct() {
        parent::__construct('formRegisterModel', ['enctype' => 'multipart/form-data',
        'urlRedireccion' => 'modelsAdmin.php']);
        $this->modelService = ModelService::getInstance();
    }

    private function generateGearboxSelector($name, $tipoSeleccionado=null)
    {
        $html = "<label for=\"gb\">Caja de cambios:</label>
            <select id=\"gb\" name=\"{$name}\">";
        foreach(self::DEFAULTGEARBOX as $gearbox) {
            $html .= "<option ";
            $selected='';
            if ($tipoSeleccionado && $gearbox == $tipoSeleccionado)
                $selected='selected';
            $html .= "value=\"{$gearbox}\" {$selected}>{$gearbox}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    private function generateCategorySelector($name, $tipoSeleccionado=null)
    {
        $html = "<label for=\"ct\">Categoria:</label>
            <select id=\"ct\" name=\"{$name}\">";
        foreach(self::DEFAULTCATEGORY as $category) {
            $html .= "<option ";
            $selected='';
            if ($tipoSeleccionado && $category == $tipoSeleccionado)
                $selected='selected';
            $html .= "value=\"{$category}\" {$selected}>{$category}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    private function generateFuelTypeSelector($name, $tipoSeleccionado=null)
    {
        $html = "<label for=\"ft\">Tipo de combustible:</label>
            <select id=\"ft\" name=\"{$name}\">";
        foreach(self::DEFAULTFUELTYPE as $fuelType) {
            $html .= "<option ";
            $selected='';
            if ($tipoSeleccionado && $fuelType == $tipoSeleccionado)
                $selected='selected';
            $html .= "value=\"{$fuelType}\" {$selected}>{$fuelType}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $brand = $datos['brand'] ?? '';
        $model = $datos['model'] ?? '';
        $submodel = $datos['submodel'] ?? '';
        $gearbox = $datos['gearbox'] ?? '';
        $category = $datos['category'] ?? '';
        $fuelType = $fuelType['gearbox'] ?? '';
        $seatCount = $datos['seatCount'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['brand', 'model', 'submodel','gearbox', 'category','fuelType', 'seatCount', 'archivo'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta

        $gearboxSelector = $this->generateGearboxSelector('gearbox', $gearbox);
        $categorySelector = $this->generateCategorySelector('category', $category);
        $fuelTypeSelector = $this->generateFuelTypeSelector('fuelType', $fuelType);


        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="brand">Marca:</label>
                <input id="brand" type="text" name="brand" value="$brand" />{$erroresCampos['brand']}
            </div>
            <div>
                <label for="model">Modelo:</label>
                <input id="model" type="text" name="model" value="$model" />{$erroresCampos['model']}
            </div>
            <div>
                <label for="submodel">Submodelo:</label>
                <input id="submodel" type="text" name="submodel" value="$submodel" />{$erroresCampos['submodel']}
            </div>
            <div>
                $gearboxSelector{$erroresCampos['gearbox']}
            </div>
            <div>
                $categorySelector{$erroresCampos['category']}
            </div>
            <div>
                $fuelTypeSelector{$erroresCampos['fuelType']}
            </div>
            <div>
                <label for="seatcount">Numero de asientos:</label>
                <input id="seatcount" type="text" name="seatCount" value="$seatCount" />{$erroresCampos['seatCount']}
            </div>
            <div>
            <label for="archivo">Archivo (Máx. 8MB):
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
        
        $brand = trim($datos['brand'] ?? '');
        $brand = filter_var($brand, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $brand || empty($brand))
            $this->errores['brand'] = 'La marca del modelo no puede estar vacía';

        $model = trim($datos['model'] ?? '');
        $model = filter_var($model, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $model || empty($model) )
            $this->errores['model'] = 'El modelo no puede estar vacio.';

        $submodel = trim($datos['submodel'] ?? '');
        $submodel = filter_var($submodel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $submodel || empty($submodel))
            $this->errores['submodel'] = 'El submodelo del modelo no puede estar vacío';

        $gearbox = trim($datos['gearbox'] ?? '');
        $gearbox = filter_var($gearbox, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $gearbox || empty($gearbox))
            $this->errores['gearbox'] = 'La caja de cambios del modelo no puede estar vacía';

        if (!self::validGearbox($gearbox))
            $this->errores['gearbox'] = "La caja de cambios no es válida. Introduce uno de los siguientes: 'Manual', 'Automatic', 'Semi-automatic', 'Duplex'.";

        $category = trim($datos['category'] ?? '');
        $category = filter_var($category, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $category || empty($category))
            $this->errores['category'] = 'La categoria del modelo no puede estar vacía';

        if (!self::validCategory($category))
            $this->errores['category'] = "La categoria no es válida. Introduce uno de los siguientes: 'Coupe', 'Pickup', 'Roadster', 'Sedan', 'Small-car', 'Suv', 'Van'.";

        $fuelType = trim($datos['fuelType'] ?? '');
        $fuelType = filter_var($fuelType, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $fuelType || empty($fuelType))
            $this->errores['fuelType'] = 'El tipo de combustible del modelo no puede estar vacío';

        if (!self::validFuelType($fuelType))
            $this->errores['fuelType'] = "El tipo de combustible no es válido. Introduce uno de los siguientes: 'Diesel', 'Electric-hybrid', 'Electric', 'Petrol', 'Plug-in-hybrid'.";

        $seatCount = trim($datos['seatCount'] ?? '');
        $seatCount = filter_var($seatCount, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $seatCount || empty($seatCount))
            $this->errores['seatCount'] = 'El numero de asientos del vehiculo no puede estar vacío';

        if( !is_numeric($seatCount))
            $this->errores['seatCount'] = 'Formato del numero de asientos inválido! Debe ser un numero';

        if ($seatCount < 2 || $seatCount > 9)
            $this->errores['seatCount'] = 'Formato del numero de asientos inválido! Debe ser un numero entre el 2 y el 9';

        //Procesar la imagen del modelo:

        // Verificamos que la subida ha sido correcta
        $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if (! $ok) {
            $this->errores['archivo'] = 'Error al subir el archivo. Es necesario subir una foto del modelo para registrarlo.';
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
        $imagenSubidaEnElServidor = $this->modelService->saveImage($image);
        $fichero = "{$imagenSubidaEnElServidor->getId()}-{$imagenSubidaEnElServidor->getPath()}";
        $ruta = implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)).'\img\model', $fichero]);

        if (!move_uploaded_file($tmp_name, $ruta)) {
            $this->errores['archivo'] = 'Error al mover el archivo';
        }

        if (count($this->errores) === 0) {
            $model = $this->modelService->createModel($brand, $model, $submodel, $gearbox, $category, $fuelType, $seatCount, $imagenSubidaEnElServidor->getId());
            if (!$model)
                $this->errores[] = "Can not create the model!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validFuelType($fuelType = array()) {
        return in_array($fuelType, self::DEFAULTFUELTYPE);
    }

    protected function validGearbox($gearbox = array()) {
        return in_array($gearbox, self::DEFAULTGEARBOX);
    }

    protected function validCategory($category = array()) {
        return in_array($category, self::DEFAULTCATEGORY);
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
