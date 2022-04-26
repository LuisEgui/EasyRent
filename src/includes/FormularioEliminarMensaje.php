<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';

class FormularioEliminarMensaje extends Formulario {

    private $messageService;

    public function __construct() {
        parent::__construct('formDeleteMessage', ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista

        // Se leen todos los mensajes de la base de datos
        $mensajes = $this->messageService->readAllMessages();

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>Mensaje</th>
                </tr>
        EOS;

        foreach($mensajes as $mensaje) {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="deletedMessage" value="{$mensaje->getId()} required"></td>
                    <td>{$mensaje->getMensaje()}</td>
                </tr>
            EOS;
        }
        $html .= <<<EOS
            </table>
            </div>
            <div>
                <button type="submit" name="delete"> Eliminar </button>
            </div>
        EOS;
            
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        if(!isset($datos['deletedMessage']))
            $this->errores[] = 'Debe seleccionar un mensaje.';

        if (count($this->errores) === 0) {
            $result = $this->messageService->deleteMessage($datos['deletedMessage']);
            if (!$result)
                $this->errores[] = "Message doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}