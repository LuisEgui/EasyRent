<?php
namespace easyrent\includes\forms;

use easyrent\includes\service\AdvertisementService;
use easyrent\includes\persistance\repository\MysqlPriorityRepository;

class FormularioActualizarPriorityAd extends Formulario {
    private $advertisementService;

    private $priorityRepository;

    public function __construct() {
        parent::__construct('formUpdatePriority', ['urlRedireccion' => '../index.php']);
        $this->advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
        $this->priorityRepository = $GLOBALS['db_priority_repository'];
    }

    protected function generaCamposFormulario(&$datos) {
        $priorities = $this->priorityRepository->findAll();
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Update priority</legend>
            <div>
                <label for="priority">Prioridad:</label>
                <select id="priority" name="priority">
        EOF;
        if(count($priorities) === 0) $html .= 0;
        for ($i = 0; $i < count($priorities); $i++) {
            //hacer algo para que vehiculos reservados no salgan
            $html .= <<<EOF
                <option value="
            EOF;
            $html .= $priorities[$i]->getLevel();
            $html .= <<<EOF
                ">
            EOF;
            $html .= $priorities[$i]->getLevel();
            $html .= <<<EOF
                </option>
            EOF;
        }
        $html .= <<<EOF
                </select>
            </div>
            <div>
                <label><input type="submit" name="update" value="Actualizar"></label>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos) {
        $adED = $datos['endDate'];
        if ($this->advertisementService->updateAdEndDate($_GET["id"], $adED))
            header("Location: {$this->urlRedireccion}");
        else
            $this->errores[] = "Can't upload the end date of this ad! There's a conflict with other existing ads";
    }
}
