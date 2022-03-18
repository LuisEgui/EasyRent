<?php

require_once __DIR__.'\Formulario.php';
require_once __DIR__.'\User.php';

class FormularioRegistroUsuario extends Formulario {
    
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el email introducido previamente o se deja en blanco
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email', 'password', 'role'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Email, contraseña y role</legend>
            <div>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" value="$email" />
                {$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <di>
                <label for="role">Role:</label>
                <input id="role" type="text" name="role" />
                {$erroresCampos['role']}
            <div>
                <button type="submit" name="register">Registrarse</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $email || empty($email))
            $this->errores['email'] = 'El email del usuario no puede estar vacío';
        
        if( !self::validateEmail($email))
            $this->errores['email'] = 'Formato de email inválido!';
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }

        $role = trim($datos['role'] ?? '');
        $role = filter_var($role, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$role || empty($role))
            $this->errores['role'] = 'El role no puede estar vacío.';
        
        if (!self::validRole($role))
            $this->errores['role'] = "El role no es válido. Introduce uno de los siguientes: admin, particular, enterprise.";
        
        if (count($this->errores) === 0) {
            $usuario = User::createUser($email, $password, $role);
        
            if (!$usuario)
                $this->errores[] = "";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validateEmail($email) {
        $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
        return preg_match($pattern, $email);
    }

    protected function validRole($role = array()) {
        $defaultRoles = array('admin', 'particular', 'enterprise');
        return in_array($role, $defaultRoles);
    }
    
}
