<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';
require_once __DIR__.'/UserService.php';

class FormularioEliminarMensaje extends Formulario {

    private $messageService;
    private $userService;
    
    public function __construct() {
        parent::__construct('formDeleteMessage', ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        $mensajes = $this->messageService->readAllMessages();



        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la
        // posicion del array erroresCampos correcta
        $erroresCampos = self::generaErroresCampos(['borrarMensaje'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>Autor  </th>
                    <th>Fecha  </th>
                    <th>Texto  </th>
                </tr>
            </table>
            </div>
        EOS;

        foreach($mensajes as $message) {
            $idAuthor = $message->getAuthor();
            $userAuthor = $this->userService->readUserById($idAuthor);
            $creados = 0;
            if($userAuthor->getEmail() == $_SESSION['email']){
                $html .= <<<EOS
                    <tr>
                        <td><input type="radio" name="borrarMensaje" value="{$message->getId()} required"></td>
                        <td>{$userAuthor->getEmail()}</td>
                        <td>{$message->getSendTime()}</td>
                        <td>{$message->getTxt()}</td>
                    </tr>
                EOS;
                $creados++;
            }
        }
        if($creados = 0){
            $html .= <<<EOS
                    <tr>
                        <td><input type="radio" name="borrarMensaje" value=""></td>
                        <td>{"No ha creado ningún mensaje"}</td>
                    </tr>
                EOS;
        }
        $html .= <<<EOS
            <div>
                <button type="submit" name="delete"> Eliminar </button>
            </div>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $idDeleteMessage = $datos['borrarMensaje'];

        if (empty($idDeleteMessage))
        $this->errores['seleccionMensaje'] = 'Debe seleccionar una opción';
        
        if (count($this->errores) === 0) {
            $delMessage = $this->messageService->deleteMessage($idDeleteMessage);

        if ($delMessage === null)
            $this->errores['borrarMensaje'] = 'No se ha podido borrar el mensaje!';

        header("Location: {$this->urlRedireccion}");
        }
    }


    
}
