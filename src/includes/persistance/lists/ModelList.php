<?php

namespace easyrent\includes\persistance\lists;

//use easyrent\includes\service\ModelService;

/**
 * Class for modelList entity.
 */
class ModelList
{
    /**
     * @var string ModelList array list
     */
    private $array;

    /**
     * Creates a ModelList
     *
     * @param string $array array list
     * @return void
     */
    public function __construct($array = array())
    {
        $this->array = $array;
    }

    /**
     * Returns modelList's array
     * @return array array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Sets modelList's array
     * @param string $vin Vehicle vin
     * @return void
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    private function cmpBrand($a, $b)
    {
        return ($a->getBrand() < $b->getBrand()) ? 1 : 0;
    }

    private function cmpModel($a, $b)
    {
        return ($a->getModel() < $b->getModel()) ? 1 : 0;
    }

    private function cmpCategory($a, $b)
    {
        return ($a->getCategory() < $b->getCategory()) ? 1 : 0;
    }

    private function cmpGearbox($a, $b)
    {
        return ($a->getGearbox() < $b->getGearbox()) ? 1 : 0;
    }

    private function cmpFuelType($a, $b)
    {
        return ($a->getFuelType() < $b->getFuelType()) ? 1 : 0;
    }

    private function cmpSeatCount($a, $b)
    {
        return ($a->getSeatCount() < $b->getSeatCount()) ? 1 : 0;
    }

    private function cmpFecha($a, $b)
    {
        return ($a->getTimeStamp() > $b->getTimeStamp()) ? 1 : 0;
    }

    function orderBy($function){
        $len = count($this->array);
        switch ($function) {
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
