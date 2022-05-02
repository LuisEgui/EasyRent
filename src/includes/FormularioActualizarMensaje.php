<?php

require_once RAIZ_APP.'/Formulario.php';
require_once RAIZ_APP.'/Message.php';

class FormularioActualizarMensaje extends Formulario {

    private $MessageService;
    
    public function __construct($id) {
        parent::__construct('formUpdateMessage', ['urlRedireccion' => 'foro.php']);
        $this->MessageService = new MessageService($GLOBALS['db_message_repository'], $GLOBALS['db_image_repository']);
        $this->idMessage = $id;
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el mensaje introducido previamente o se deja en blanco
        $mensaje = $datos['mensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['mensaje'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Actualizar mensaje:</legend>
            <div>
                <label for="mensaje">Nuevo mensaje:</label>
                <input id="mensaje" type="text" name="mensaje" value="$mensaje" />
                {$erroresCampos['mensaje']}
            </div>
            <div>
                <button type="submit" name="update">Actualizar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$mensaje || empty($mensaje))
            $this->errores['mensaje'] = 'El mensaje no puede estar vacío';

        if (count($this->errores) === 0) {
            $rs = $this->MessageService->updateMessage($mensaje);
        
            if (!$rs)
                $this->errores[] = "Can't upload message!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}