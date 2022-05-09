<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';
require_once __DIR__.'/UserService.php';

class FormularioResponderMensaje extends Formulario {

    private $messageService;
    private $userService;
    private $messageId;
    
    public function __construct($id) {
        parent::__construct('formAnswerMessage?id=' . $id, ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
        $this->messageId = $id;
    }
    
    protected function generaCamposFormulario(&$datos) {
       
        $html = <<<EOS
        <fieldset>
            <div>
                <label for="txt">Mensaje:</label>
                <input id="txt" type="text" name="txt"}
            </div>
            <div>
                <button type="submit" name="answer"> Responder </button>
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
        
        if (count($this->errores) === 0) {
            $newMessage = $this->messageService->createMessage($txt, $author->getId(), $this->messageId);

        if ($newMessage === null)
            $this->errores['txt'] = 'No se ha podido agregar el mensaje!';

        header("Location: {$this->urlRedireccion}");
        }
    }


    
}
