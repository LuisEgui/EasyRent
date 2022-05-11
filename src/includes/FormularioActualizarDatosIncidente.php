<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/DamageService.php';
require_once __DIR__.'/Damage.php';

class FormularioActualizarDatosIncidente extends Formulario {

    private $damageService;

    private $damageIdToUpdate;

    private $defaultStates = array(true, false);

    public function __construct($idToUpdate) {
        parent::__construct('formUpdateDamageData'. $idToUpdate, ['urlRedireccion' => 'incidentesAdmin.php']);
        $this->damageService = DamageService::getInstance();
        if(isset($idToUpdate)){
            $this->damageIdToUpdate = $idToUpdate;
        }
    }

    private function generateStateSelector($selectedState)
    {
        $html = "<label for=\"states\">Estado del incidente:</label>
                <select id=\"states\" name=\"state\">";
        foreach($this->defaultStates as $state) {
            $string = "No reparado";
            if($state)
                $string = "Reparado";
            $html .= "<option ";
            $selected='';
            if ($selectedState && $state == $selectedState)
                $selected='selected';
            $html .= "value=\"{$state}\" {$selected}>{$string}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {

        $damage =  $this->damageService->readDamageById($this->damageIdToUpdate);
        $damageDescription = $damage->getDescription();
        $damageState = $damage->getIsRepaired();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['description', 'state'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta

        // Se genra el selector de estados del vehiculo
        $stateSelector = $this->generateStateSelector($damageState);

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="description">Descripción:</label>
                <input id="description" type="text" name="description" value="$damageDescription" style="width : 600px; height : 600px"/>{$erroresCampos['description']}
            </div>
            <div>
                $stateSelector{$erroresCampos['state']}
            </div>
            <div>
                <button type="submit" name="update"> Actualizar </button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $damageDescription = trim($datos['description'] ?? '');
        $damageDescription = filter_var($damageDescription, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $damageDescription || empty($damageDescription))
            $this->errores['description'] = 'La descripcion de la incidencia no puede estar vacía';

        $state = trim($datos['state'] ?? '');
        $state = filter_var($state, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if( !self::validateState($state))
            $this->errores['state'] = 'El estado introducido es inválido!';

        if (count($this->errores) === 0) {
            $this->damageService->updateDamage($state, $damageDescription, $this->damageIdToUpdate);
            header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validateState($state) {
        return in_array($state, $this->defaultStates);
    }
}