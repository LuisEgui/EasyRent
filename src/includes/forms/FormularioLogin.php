<?php

namespace easyrent\includes\forms;

use easyrent\includes\config;
use easyrent\includes\service\UserService;

class FormularioLogin extends Formulario
{

    private $userService;

    public function __construct()
    {
        parent::__construct('formLogin', ['urlRedireccion' => '../index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos =
            self::generaErroresCampos(['email', 'password'], $this->errores, 'span', ['class' => 'error']);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Email y contraseña</legend>
            <div>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" value="$email" placeholder="example@easyrent.com"/>
                {$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" autocomplete="on" placeholder="********"/>
                {$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="login">Entrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($email)) {
            $this->errores['email'] = 'El email del usuario no puede estar vacío';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($password)) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }

        if (count($this->errores) === 0) {
            $logged = $this->userService->login($email, $password);

            if (!$logged) {
                $this->errores[] = "El email del usuario o el password no coinciden";
            } else {
                $usuario = $this->userService->readUserByEmail($email);
                $_SESSION['login'] = true;
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['esAdmin'] = $usuario->hasRole('admin');
            }
        }
    }
}
