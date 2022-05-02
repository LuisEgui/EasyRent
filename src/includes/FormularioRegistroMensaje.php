<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';

class FormularioRegistroMensaje extends Formulario {

    private $messageService;
    
    public function __construct() {
        parent::__construct('formRegisterMessage', ['urlRedireccion' => 'foro.php']);
        $this->$messageService = new MessageService($GLOBALS['db_message_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $message = $datos['message'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['message'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la posicion del array erroresCampos correcta
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="message">Mensaje:</label>
                <input id="message" type="text" name="message" value="$message" />{$erroresCampos['message']}
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
        $message = trim($datos['message'] ?? '');

        if ( ! $message || empty($message))
            $this->errores['message'] = 'El mensaje no puede estar vacío';
        
        if (count($this->errores) === 0) {
            $newMessage = $this->messageService->createMessage($message);
        
 
            header("Location: {$this->urlRedireccion}");
        }
    }


    
}