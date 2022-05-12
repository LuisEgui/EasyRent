<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ModelService;
use easyrent\includes\service\VehicleService;
use easyrent\includes\service\lists\ModelList;

class FormularioEliminarModelo extends Formulario {

    private $modelService;

    private $vehicleService;

    private $modelsList;

    private $orderModelsBy;

    public function __construct($orderByFunction) {
        parent::__construct('formDeleteModel', ['urlRedireccion' => 'modelsAdmin.php']);
        $this->modelService = ModelService::getInstance();
        $this->vehicleService = VehicleService::getInstance();
        $this->modelsList = new ModelList();
        if(isset($orderByFunction)){
            $this->orderModelsBy = $orderByFunction;
        }
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos(['asignedVehicle'], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso de la posicion del array erroresCampos correcta

        // Se leen todos los vehiculos de la base de datos y se almacenan en un array de la instancia de la clase VehicleList
        $this->modelsList->setArray($this->modelService->readAllModels());
        if(isset($this->orderModelsBy)){
            $this->modelsList->orderBy($this->orderModelsBy);
        }

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Submodelo</th>
                    <th>ID Imagen</th>
                    <th>Fecha de modificación</th>
                </tr>
        EOS;

        foreach($this->modelsList->getArray() as $model) {
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="deletedModelId" value="{$model->getId()}" required></td>
                    <td>{$model->getBrand()}</td>
                    <td>{$model->getModel()}</td>
                    <td>{$model->getSubmodel()}</td>
                    <td>{$model->getImage()}</td>
                    <td>{$model->getTimeStamp()}</td>
                </tr>
            EOS;
        }
        $html .= <<<EOS
            </table>
            </div>
            <div>
                <button type="submit" name="delete"> Eliminar </button>
            </div>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        if(!isset($datos['deletedModelId']))
            $this->errores[] = 'Debe seleccionar un modelo.';

        $vehicles = $this->vehicleService->readVehiclesByModel($datos['deletedModelId']);
        if(!empty($vehicles))
            $this->errores[] = 'Existen vehiculos asociados al modelo que desea eliminar. Por favor, elimine en primer lugar dichos vehiculos y, posteriormente, el modelo.';

        if (count($this->errores) === 0) {
            echo "t están vacilando";
            $result = $this->modelService->deleteModelById($datos['deletedModelId']);
            if (!$result)
                $this->errores[] = "Model doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}
