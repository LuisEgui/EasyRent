<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\UserService;

class FormularioActualizarPasswordUsuario extends Formulario {

    private $userService;

    public function __construct() {
        parent::__construct('formPasswordUpdate', ['urlRedireccion' => RUTA_APP.'/index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['password', 'previousPassword'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        return <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Actualizar contraseña</legend>
            <div>
                <label for="previousPassword">Contraseña anterior:</label>
                <input id="previousPassword" type="password" name="previousPassword" autocomplete="on" placeholder="********"/>{$erroresCampos['previousPassword']}
            </div>
            <div>
                <label for="password">Nueva contraseña:</label>
                <input id="password" type="password" name="password" autocomplete="on" placeholder="********"/>{$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="update">Modificar</button>
            </div>
        </fieldset>
        EOF;
    }

    private function validatePreviousPassword($previousPassword) {
        $user = $this->userService->readUserByEmail($_SESSION['email']);
        return password_verify($previousPassword, $user->getPassword());
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $rs = null;

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( !$password || empty($password) )
            $this->errores['password'] = 'El password no puede estar vacío.';

        $previousPassword = trim($datos['previousPassword'] ?? '');
        $previousPassword = filter_var($previousPassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$previousPassword || empty($previousPassword))
            $this->errores['previousPassword'] = 'La contraseña anterior no puede estar vacía!.';

        if (count($this->errores) === 0) {
            if (!$this->validatePreviousPassword($previousPassword))
                $this->errores['previousPassword'] = 'La contraseña anterior no coincide!';
            else
                $rs = $this->userService->updateUserPassword($password);

            if (!$rs)
                $this->errores[] = "Can't upload user password!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

}
