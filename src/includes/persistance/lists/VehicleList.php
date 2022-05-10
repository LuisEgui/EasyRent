<?php

namespace easyrent\includes\persistance\lists;

use easyrent\includes\service\ModelService;

/**
 * Class for vehicleList entity.
 */
class VehicleList
{
    /**
     * @var string VehicleList array list
     */
    private $array;

    /**
     * Creates a VehicleList
     *
     * @param string $array array list
     * @return void
     */
    public function __construct($array = array())
    {
        $this->array = $array;
    }

    /**
     * Returns vehiclesList's array
     * @return array array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Sets vehiclesList's array
     * @param string $vin Vehicle vin
     * @return void
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    private function cmpVin($a, $b)
    {
        if ($a->getVin() == $b->getVin()) {
            return 0;
        }
        return ($a->getVin() < $b->getVin()) ? 1 : 0;
    }

    private function cmpLicensePlate($a, $b)
    {
        if ($a->getLicensePlate() == $b->getLicensePlate()) {
            return 0;
        }
        return ($a->getLicensePlate() < $b->getLicensePlate()) ? 1 : 0;
    }

    private function cmpBrand($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getBrand() == $bModel->getBrand()) {
            return 0;
        }
        return ($aModel->getBrand() < $bModel->getBrand()) ? 1 : 0;
    }

    private function cmpModel($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getModel() == $bModel->getModel()) {
            return 0;
        }
        return ($aModel->getModel() < $bModel->getModel()) ? 1 : 0;
    }

    private function cmpCategory($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getCategory() == $bModel->getCategory()) {
            return 0;
        }
        return ($aModel->getCategory() < $bModel->getCategory()) ? 1 : 0;
    }

    private function cmpGearbox($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getGearbox() == $bModel->getGearbox()) {
            return 0;
        }
        return ($aModel->getGearbox() < $bModel->getGearbox()) ? 1 : 0;
    }

    private function cmpFuelType($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getFuelType() == $bModel->getFuelType()) {
            return 0;
        }
        return ($aModel->getFuelType() < $bModel->getFuelType()) ? 1 : 0;
    }

    private function cmpSeatCount($a, $b)
    {
        $modelService = ModelService::getInstance();
        $aModel = $modelService->readModelById($a->getModel());
        $bModel = $modelService->readModelById($b->getModel());
        if ($aModel->getSeatCount() == $bModel->getSeatCount()) {
            return 0;
        }
        return ($aModel->getSeatCount() < $bModel->getSeatCount()) ? 1 : 0;
    }

    private function cmpLocation($a, $b)
    {
        if ($a->getLocation() == $b->getLocation()) {
            return 0;
        }
        return ($a->getLocation() < $b->getLocation()) ? 1 : 0;
    }

    private function cmpState($a, $b)
    {
        if ($a->getState() == $b->getState()) {
            return 0;
        }
        return ($a->getState() < $b->getState()) ? 1 : 0;
    }

    private function cmpFecha($a, $b)
    {
        if ($a->getTimeStamp() == $b->getTimeStamp()) {
            return 0;
        }
        return ($a->getTimeStamp() > $b->getTimeStamp()) ? 1 : 0;
    }

    function orderBy($function){
        $len = count($this->array);
        switch ($function) {
            case "cmpVin":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpVin($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpLicensePlate":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpLicensePlate($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpBrand":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpBrand($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpModel":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpModel($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpGearbox":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpGearbox($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpFuelType":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpFuelType($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpSeatCount":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpSeatCount($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpLocation":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpLocation($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpState":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpState($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpFecha":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpFecha($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
        }
    } 
}
