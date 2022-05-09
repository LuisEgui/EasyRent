<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/DamageService.php';

class FormularioActualizarIncidente extends Formulario {

    private $damageService;
    private $damageId;

    public function __construct($id) {
        parent::__construct('formEditDamage' . $id, ['urlRedireccion' => 'incidente.php']);
        $this->damageService = new DamageService($GLOBALS['db_damage_repository']);
        $this->damageId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    private static function generateIsRepairedSelector($name, $tipoSeleccionado=null)
    {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="{$name}" value="{$isRepairedString} required"></td>
                    <td>{"SI"}</td>
                </tr>
            EOS;
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="{$name}" value="{$isRepairedString} required"></td>
                    <td>{"NO"}</td>
                </tr>
            EOS;
        return $html;
    }
    
    protected function generaCamposFormulario(&$datos) {

        // Se reutiliza el email introducido previamente o se deja en blanco
        $description = $datos['description'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la
        // posicion del array erroresCampos correcta
        $erroresCampos = self::generaErroresCampos(['description', 'isRepaired'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
        $htmlErroresGlobales
        EOS;
        $isRepairedSelector = self::generateIsRepairedSelector('isRepaired', $isRepairedString);

        $html .= <<<EOS
        <fieldset>
            <div>
                <label for="description">Descripción:</label>
                <input id="description" type="text" name="description" value="$description" style="width : 600px; heigth : 600px"/>{$erroresCampos['description']}
            </div>
            <div>
            <label>¿Está reparado?: </label>
            $isRepairedSelector{$erroresCampos['isRepaired']}
            </div>
            <div>
                <button type="submit" name="edit"> Actualizar </button>
            </div>
        </fieldset>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos) {            
        $this->errores = [];

        $isRepairedString = trim($datos['isRepaired'] ?? '');
        $isRepairedString = filter_var($isRepairedString, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = trim($datos['description'] ?? '');

        if (!$isRepairedString || empty($isRepairedString))
            $this->errores['isRepaired'] = 'Debe conocerse si está reparado o no.';
            $isRepaired = false;
        else{
            if($isRepairedString == "SI") $isRepaired = true; 
            else $isRepaired = false;
        }

        if (count($this->errores) === 0) {
            $edDamage = $this->damageService->updateDamage($isRepaired, $description, $this->damageId);

        if ($edDamage === null)
            $this->errores['description'] = 'No se ha podido actualizar el incidente!';

        header("Location: {$this->urlRedireccion}");
        }
    }


    
}
