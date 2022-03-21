<?php

require_once __DIR__.'\Formulario.php';
require_once __DIR__.'\User.php';

class FormularioActualizarUsuario extends Formulario {
    
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Contraseña</legend>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
                <button type="submit" name="register">Modificar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( !$password || empty($password) )
            $this->errores['password'] = 'El password no puede estar vacío.';
        
        if (count($this->errores) === 0) {
            $usuario = User::findUserByEmail($_SESSION['email']);
            $rs = User::updateUser($usuario, $password);
        
            if (!$rs)
                $this->errores[] = "Not valid user";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }    
}
