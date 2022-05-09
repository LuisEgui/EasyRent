<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';
require_once __DIR__.'/UserService.php';

class FormularioActualizarMensaje extends Formulario {

    private $messageService;
    private $userService;
    private $messageId;

    public function __construct($id) {
        parent::__construct('formEditMessage' . $id, ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
        $this->messageId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    }
    
    protected function generaCamposFormulario(&$datos) {

        // Se reutiliza el email introducido previamente o se deja en blanco
        $mensaje = $datos['txt'] ?? '';
        $mensaje = $this->messageService->readMessageById($this->messageId)->getTxt();
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la
        // posicion del array erroresCampos correcta
        $erroresCampos = self::generaErroresCampos(['txt', 'seleccionMensaje'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
        $htmlErroresGlobales
        EOS;

        $html .= <<<EOS
        <fieldset>
            <div>
                <label for="txt">Mensaje:</label>
                <input id="txt" type="text" name="txt" value="$mensaje" style="width : 600px; heigth : 600px"/>{$erroresCampos['txt']}
            </div>
            <div>
                <button type="submit" name="answer"> Actualizar </button>
            </div>
        </fieldset>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos) {            
        $this->errores = [];
        $txt = trim($datos['txt'] ?? '');
        $author = $this->userService->readUserByEmail($_SESSION['email']);

        if (empty($txt))
            $this->errores['txt'] = 'El mensaje no puede estar vacío';
        if (empty($this->messageId))
        $this->errores['seleccionMensaje'] = 'Debe seleccionar una opción';
        
        if (count($this->errores) === 0) {
            $edMessage = $this->messageService->updateMessage($txt, $this->messageId);

        if ($edMessage === null)
            $this->errores['txt'] = 'No se ha podido agregar el mensaje!';

        header("Location: {$this->urlRedireccion}");
        }
    }


    
}
