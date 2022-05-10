<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/MessageService.php';
require_once __DIR__.'/UserService.php';

class FormularioActualizarMensaje extends Formulario {

    private $messageService;
    private $userService;
    
    public function __construct() {
        parent::__construct('formEditMessage', ['urlRedireccion' => 'foro.php']);
        $this->messageService = new MessageService($GLOBALS['db_message_repository']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        $mensajes = $this->messageService->readAllMessages();

        // Se reutiliza el email introducido previamente o se deja en blanco
        $mensaje = $datos['txt'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso d la
        // posicion del array erroresCampos correcta
        $erroresCampos = self::generaErroresCampos(['txt', 'seleccionMensaje'], $this->errores, 'span', array('class' => 'error'));
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
            if($userAuthor->getEmail() == $_SESSION['email']){
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="seleccionMensaje" value="{$message->getId()} required"></td>
                    <td>{$userAuthor->getEmail()}</td>
                    <td>{$message->getSendTime()}</td>
                    <td>{$message->getTxt()}</td>
                </tr>
            EOS;
            }
        }
        $html .= <<<EOS
        <fieldset>
            <div>
                <label for="txt">Mensaje:</label>
                <input id="txt" type="text" name="txt" value="$mensaje" />{$erroresCampos['txt']}
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
        $idMessage = $datos['seleccionMensaje'];
        $author = $this->userService->readUserByEmail($_SESSION['email']);

        if (empty($txt))
            $this->errores['txt'] = 'El mensaje no puede estar vacío';
        if (empty($idParentMessage))
        $this->errores['seleccionMensaje'] = 'Debe seleccionar una opción';
        
        if (count($this->errores) === 0) {
            $edMessage = $this->messageService->updateMessage($txt, $idMessage);

        if ($edMessage === null)
            $this->errores['txt'] = 'No se ha podido agregar el mensaje!';

        header("Location: {$this->urlRedireccion}");
        }
    }


    
}
