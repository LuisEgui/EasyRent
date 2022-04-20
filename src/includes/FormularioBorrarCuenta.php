<?php

require_once RAIZ_APP.'/Formulario.php';
require_once RAIZ_APP.'/UserService.php';

class FormularioBorrarCuenta extends Formulario {

    private $userService;
    
    public function __construct() {
        parent::__construct('formDeleteUser', ['urlRedireccion' => 'index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }
    
    protected function generaCamposFormulario(&$datos) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Borrar cuenta de usuario</legend>
            <div>
                <p>¿Estás seguro de que quieres borrar esta cuenta?</p>
            </div>
            <div>
                <label><input type="submit" name="confirm" value="Si"></label>
                <label><input type="submit" name="confirm" value="No"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $result = $datos['confirm'];

        if ($result == 'Si') {
            if ($this->userService->deleteUserAccount())
                header("Location: {$this->urlRedireccion}");
            else
                $this->errores[] = "Can't delete user account!";
        }
    }
    
}