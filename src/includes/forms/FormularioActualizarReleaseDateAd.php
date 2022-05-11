<?php
namespace easyrent\includes\forms;

use easyrent\includes\service\AdvertisementService;

class FormularioActualizarReleaseDateAd extends Formulario {
    private $advertisementService;

    public function __construct() {
        parent::__construct('formUpdateReleaseDate', ['urlRedireccion' => 'index.php']);
        $this->advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Update release date</legend>
            <div>
                <label for="releaseDate">Release date:</label>
                <input type="datetime-local" id="releaseDate" name="releaseDate" >
            </div>
            <div>
                <label><input type="submit" name="update" value="Actualizar"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos) {
        $adRD = $datos['releaseDate'];
        if ($this->advertisementService->updateAdReleaseDate($_GET["id"], $adRD))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the release date of this ad! The release date can't be later than the end date";
    }
}