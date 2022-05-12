<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\UserService;

class FormularioRegistroUsuario extends Formulario
{

    private $userService;
    const PARTICULAR = 'particular', ENTERPRISE = 'enterprise';
    const ROLES = [self::PARTICULAR => 'Particular', self::ENTERPRISE => 'Enterprise'];

    public function __construct()
    {
        parent::__construct('formRegisterUser', ['urlRedireccion' => RUTA_APP.'/index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    private static function generateRoleSelector($tipoSeleccionado = null)
    {
        $html = '';
        foreach (self::ROLES as $clave => $valor) {
            $html .= "<label>";
            $html .= "<input type='radio' name=\"role\" ";
            $selected='';
            if ($tipoSeleccionado && $clave == $tipoSeleccionado) {
                $selected='checked';
            }
            $html .= "value=\"{$clave}\" {$selected}>{$valor} </label>";
        }
        $html .= '';

        return $html;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $email = $datos['email'] ?? '';
        $role = $datos['role'] ?? self::PARTICULAR;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email', 'password', 'role'], $this->errores, 'span', array('class' => 'error'));
        $roleSelector = self::generateRoleSelector($role);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        return <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Email, contraseña y role</legend>
            <div>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" value="$email" placeholder="example@easyrent.com"/>{$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" autocomplete="on" placeholder="********"/>{$erroresCampos['password']}
            </div>
            <div>
                <label>Role: </label>
                $roleSelector{$erroresCampos['role']}
            </div>
            <div>
                <button type="submit" name="register">Registrarse</button>
            </div>
        </fieldset>
        EOF;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (! $email || empty($email)) {
            $this->errores['email'] = 'El email del usuario no puede estar vacío';
        }

        if (!self::validateEmail($email)) {
            $this->errores['email'] = 'Formato de email inválido!';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (! $password || empty($password)) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }

        $role = trim($datos['role'] ?? '');
        $role = filter_var($role, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$role || empty($role)) {
            $this->errores['role'] = 'El role no puede estar vacío.';
        }

        if (!self::validRole($role)) {
            $this->errores['role'] = "El role no es válido. Introduce uno de los siguientes: admin, particular, enterprise.";
        }

        if (count($this->errores) === 0) {
            $usuario = $this->userService->createUser($email, $password, $role);

            if (!$usuario) {
                $this->errores[] = "User already exists!";
            } else {
                header("Location: {$this->urlRedireccion}");
            }
        }
    }

    protected function validateEmail($email)
    {
        $pattern = '/^([a-z0-9_\-]+)(\.[a-z0-9-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
        return preg_match($pattern, $email);
    }

    protected function validRole($role = array())
    {
        $defaultRoles = array('admin', 'particular', 'enterprise');
        return in_array($role, $defaultRoles);
    }
}
