<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\AdvertisementService;

class FormularioAnuncio extends Formulario {
    private $advertisementService;

    public function __construct() {
        parent::__construct('formUpdateReleaseDate', ['urlRedireccion' => RUTA_APP.'/index.php']);
        $this->advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos anuncio</legend>
            <div>
                <label for="releaseDate">Fecha inicio:</label>
                <input type="datetime-local" id="releaseDate"
                name="releaseDate" >
            </div>
            <div>
                <label for="endDate">Fecha finalizacion:</label>
                <input type="datetime-local" id="endDate"
                name="endDate">
            </div>
            <div>
                <label for="priority">Prioridad:</label>
                <select id="priority" name="priority">
                    <option value="1">Prioridad 1</option>
                    <option value="2">Prioridad 2</option>
                </select>
            </div>
            <div>
                <button type="submit" name="reserve">Reservar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $releaseDate = $datos['releaseDate'];
        $endDate = $datos['endDate'];
        $priority = $datos['priority'];
        if (count($this->errores) === 0) {
            $ad = $this->advertisementService->createAdvertisement(null, $releaseDate, $endDate, $priority);

            if (!$ad)
                $this->errores[] = "no se ha creado el anuncio";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}
