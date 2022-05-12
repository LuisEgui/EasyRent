<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\UserService;

class FormularioActualizarEmailUsuario extends Formulario
{

    private $userService;

    public function __construct()
    {
        parent::__construct('formUpdateEmail', ['urlRedireccion' => '../index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        return <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Actualizar email de usuario</legend>
            <div>
                <label for="email">Nuevo email:</label>
                <input id="email" type="text" name="email" value="$email" placeholder="example@easyrent.com"/>
                {$erroresCampos['email']}
            </div>
            <div>
                <button type="submit" name="update">Actualizar</button>
            </div>
        </fieldset>
        EOF;
    }

    protected function validateEmail($email)
    {
        $pattern = '/^([a-z0-9_\-]+)(\.[a-z0-9-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
        return preg_match($pattern, $email);
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$email || empty($email)) {
            $this->errores['email'] = 'El email del usuario no puede estar vacío';
        }

        if (!self::validateEmail($email)) {
            $this->errores['email'] = 'Formato de email inválido!';
        }

        if (count($this->errores) === 0) {
            $usuario = $this->userService->readUserByEmail($_SESSION['email']);
            $rs = $this->userService->updateUserEmail($email);

            if (!$rs) {
                $this->errores[] = "Can't upload user email!";
            } else {
                header("Location: {$this->urlRedireccion}");
            }
        }
    }
}
