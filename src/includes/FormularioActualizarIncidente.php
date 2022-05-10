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
    
    protected function generaCamposFormulario(&$datos) {
        $isRepairedString = $datos['isRepaired'] ?? '';
        $isRepaired = false;
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

        $html .= <<<EOS
        <fieldset>
            <div>
                <label for="description">Descripción:</label>
                <input id="description" type="text" name="description" value="$description" style="width : 600px; height : 600px"/>{$erroresCampos['description']}
            </div>
            <div>
            <label>¿Está reparado?: </label>
                  Sí: <input type="radio" name="isRepaired" value="SI" />
                  No: <input type="radio" name="isRepaired" value="NO" />
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
        $description = trim($datos['description'] ?? '');

        if (!$isRepairedString || empty($isRepairedString)){
            $this->errores['isRepaired'] = 'Debe conocerse si está reparado o no.';
            $isRepaired = false;
        } else{
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
