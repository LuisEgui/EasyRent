<?php

namespace easyrent\includes\forms;

use easyrent\includes\service\DamageService;
use easyrent\includes\service\lists\DamageList;

class FormularioEliminarIncidente extends Formulario {

    private $damageService;

    private $damageList;

    private $orderDamagesBy;

    public function __construct($orderByFunction) {
        parent::__construct('formDeleteDamage', ['urlRedireccion' => 'incidentesAdmin.php']);
        $this->damageService = DamageService::getInstance();
        $this->damageList = new DamageList();
        if(isset($orderByFunction)){
            $this->orderDamagesBy = $orderByFunction;
        }
    }

    protected function generaCamposFormulario(&$datos) {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores); // Se muestra como una lista
        $erroresCampos = self::generaErroresCampos([], $this->errores, 'span', array('class' => 'error')); // Agrupa los errores por campos para luego mostrar cada tipo de error donde corresponda haciendo uso de la posicion del array erroresCampos correcta

        // Se leen todos los vehiculos de la base de datos y se almacenan en un array de la instancia de la clase VehicleList
        $this->damageList->setArray($this->damageService->readAllDamages());
        if(isset($this->orderDamagesBy)){
            $this->damageList->orderBy($this->orderDamagesBy);
        }

        // Se genera el HTML asociado al formulario y los mensajes de error.
        $html = <<<EOS
        $htmlErroresGlobales
            <div>
            <table>
                <tr>
                    <th></th>
                    <th>ID Incidencia</th>
                    <th>ID Usuario</th>
                    <th>VIN Vehiculo</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Tipo</th>
                    <th>Reparado</th>
                    <th>Fecha de modificacion</th>
                </tr>
        EOS;

        foreach($this->damageList->getArray() as $damage) {
            $state = "No";
            if($damage->getIsRepaired()){
                $state = "Si";
            }
            $html .= <<<EOS
                <tr>
                    <td><input type="radio" name="deletedDamageId" value="{$damage->getId()}" required></td>
                    <td>{$damage->getId()}</td>
                    <td>{$damage->getUser()}</td>
                    <td>{$damage->getVehicle()}</td>
                    <td>{$damage->getTitle()}</td>
                    <td>{$damage->getDescription()}</td>
                    <td>{$damage->getType()}</td>
                    <td>{$state}</td>
                    <td>{$damage->getTimeStamp()}</td>
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

        if(!isset($datos['deletedDamageId']))
            $this->errores[] = 'Debe seleccionar un incidente.';

        if (!self::validDamage($datos['deletedDamageId']))
            $this->errores[] = "El incidente a eliminar no coincide con ninguno de los existentes.";
        else
            $damage = $this->damageService->readDamageById($datos['deletedDamageId']);
            if($damage->getIsRepaired() == false){
                $this->errores[] = "El incidente a eliminar no ha sido reparado previamente, por favor actualice este incidente antes de eliminarlo.";
            }

        if (count($this->errores) === 0) {
            $result = $this->damageService->deleteDamageById($datos['deletedDamageId']);
            if (!$result)
                $this->errores[] = "Damage doesn't exist!";
            else
                header("Location: {$this->urlRedireccion}");
        }
    }

    protected function validDamage($damage) {
        $damagesInDatabase = $this->damageService->readAllDamagesID();
        return in_array($damage, $damagesInDatabase);
    }
}
