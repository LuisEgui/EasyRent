<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\UserService;

class FormularioActualizarRoleUsuario extends Formulario {

    private $userService;
    const PARTICULAR = 'particular', ENTERPRISE = 'enterprise';
    const ROLES = [self::PARTICULAR => 'Particular', self::ENTERPRISE => 'Enterprise'];

    public function __construct() {
        parent::__construct('formUpdateRole', ['urlRedireccion' => RUTA_APP.'/index.php']);
        $this->userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
    }

    private static function generateRoleSelector($tipoSeleccionado=null, $id=null)
    {
        $id= $id !== null ? "id=\"{$id}\"" : '';
        $html = "<select {$id} name=\"role\">";
        foreach(self::ROLES as $clave => $valor) {
            $selected='';
            if ($tipoSeleccionado && $clave == $tipoSeleccionado) {
                $selected='selected';
            }
            $html .= "<option value=\"{$clave}\" {$selected}>{$valor}</option>";
        }
        $html .= '</select>';

        return $html;
    }

    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el role introducido previamente o se deja en PARTICULAR por defecto
        $role = $datos['role'] ?? self::PARTICULAR;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['role'], $this->errores, 'span', array('class' => 'error'));
        $roleSelector = self::generateRoleSelector($role, 'role');

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        return <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Cambiar role de usuario</legend>
            <div>
                <label for="role">Role: $roleSelector</label>{$erroresCampos['role']}
            </div>
            <div>
                <button type="submit" name="update">Actualizar</button>
            </div>
        </fieldset>
        EOF;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $role = $datos['role'] ?? self::PARTICULAR;

        $ok = array_key_exists($role, self::ROLES);

        if (!$ok)
            $this->errores['role'] = 'El tipo de role no está seleccionado o no es correcto';

        if (count($this->errores) === 0) {
            $rs = $this->userService->updateUserRole($role);

            if (!$rs)
                $this->errores[] = "Can't upload user role!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

}
