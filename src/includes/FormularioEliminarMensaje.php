<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';

class FormularioEliminarMensaje extends Formulario {

    private $messageService;
    private $idMessage;

    public function __construct($id) {
        parent::__construct('formDeleteMessage', ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository'], $GLOBALS['db_image_repository']);
        $this->idMessage = $id;
    }
    
    protected function generaCamposFormulario(&$datos) {
        $html = <<<EOF
            <div>
                <button type="submit" name="delete"> Eliminar </button>
            </div>
        EOF;
            
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $result = $this->messageService->deleteMessage($this->idMessage);

        header("Location: {$this->urlRedireccion}");
        
    }
}