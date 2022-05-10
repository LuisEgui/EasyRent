<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';

class FormularioRegistroMensaje extends Formulario {

    private $messageService;
    private $userService;
    
    public function __construct() {
        parent::__construct('formRegisterMessage', ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $message = $datos['txt'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la
        // posicion del array erroresCampos correcta
        $erroresCampos = self::generaErroresCampos(['txt'], $this->errores, 'span', array('class' => 'error'));
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="txt">Mensaje:</label>
                <input id="txt" type="text" name="txt" value="$message" />{$erroresCampos['txt']}
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
        $txt = trim($datos['txt'] ?? '');
        $author = $this->userService->readUserByEmail($_SESSION['email']);

        if (empty($txt))
            $this->errores['txt'] = 'El mensaje no puede estar vacío';
        
        if (count($this->errores) === 0) {
            $newMessage = $this->messageService->createMessage($txt, $author->getId(), null);

            if ($newMessage === null)
                $this->errores['txt'] = 'No se ha podido agregar el mensaje!';

            header("Location: {$this->urlRedireccion}");
        }
    }


    
}
