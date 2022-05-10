<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\ModelService;
use easyrent\includes\persistance\lists\ModelList;

class FormularioEliminarModelo extends Formulario {

    private $modelService;

    private $modelsList;

    private $orderModelsBy;

    public function __construct($orderByFunction) {
        parent::__construct('formDeleteModel', ['urlRedireccion' => 'modelsAdmin.php']);
        $this->modelService = ModelService::getInstance();
        $this->modelsList = new ModelList();
        if(isset($orderByFunction)){
            $this->orderModelsBy = $orderByFunction;
        }
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista

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

        if (count($this->errores) === 0) {
            $result = $this->modelService->deleteModelById($datos['deletedModelId']);
            if (!$result)
                $this->errores[] = "Model doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }
}
