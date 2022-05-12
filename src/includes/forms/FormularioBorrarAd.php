<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\AdvertisementService;

class FormularioBorrarAd extends Formulario {

    private $advertisementService;

    public function __construct() {
        parent::__construct('formDeleteAd', ['urlRedireccion' => '../index.php']);
        $this->advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Borrar anuncio</legend>
            <div>
                <p>¿Estás seguro de que quieres borrar este anuncio?</p>
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
            if ($this->advertisementService->deleteAdvertisement($_GET["id"]))
                header("Location: {$this->urlRedireccion}");
            else
                $this->errores[] = "Can't delete this ad!";
        }
    }

}
