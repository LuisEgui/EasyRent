<?php

/**
 * Class for reserveList entity.
 */
class ReserveList
{
    /**
     * @var string ReserveList array list
     */
    private $array;

    /**
     * Creates a ReserveList
     *
     * @param string $array array list
     * @return void
     */
    public function __construct($array = array())
    {
        $this->array = $array;
    }

    /**
     * Returns reserveList's array
     * @return array array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Sets reserveList's array
     * @param string $vin Vehicle vin
     * @return void
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    private function cmpId($a, $b)
    {
        return ($a->getId() < $b->getId()) ? 1 : 0;
    }

    private function cmpVIN($a, $b)
    {
        return ($a->getVehicle() < $b->getVehicle()) ? 1 : 0;
    }

    private function cmpUser($a, $b)
    {
        return ($a->getUser() < $b->getUser()) ? 1 : 0;
    }

    private function cmpPickupLocation($a, $b)
    {
        return ($a->getPickUpLocation() < $b->getPickUpLocation()) ? 1 : 0;
    }

    private function cmpReturnLocation($a, $b)
    {
        return ($a->getReturnLocation() < $b->getReturnLocation()) ? 1 : 0;
    }

    private function cmpPickupDate($a, $b)
    {
        return ($a->getPickUpTime() < $b->getPickUpTime()) ? 1 : 0;
    }

    private function cmpReturnDate($a, $b)
    {
        return ($a->getReturnTime() < $b->getReturnTime()) ? 1 : 0;
    }

    private function cmpPrice($a, $b)
    {
        return ($a->getPrice() < $b->getPrice()) ? 1 : 0;
    }

    private function cmpState($a, $b)
    {
        return ($a->getState() < $b->getState()) ? 1 : 0;
    }

    function orderBy($function){
        $len = count($this->array);
        switch ($function) {
            case "cmpId":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpId($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpVIN":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpVIN($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpUser":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpUser($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpPickupLocation":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpPickupLocation($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpReturnLocation":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpReturnLocation($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpPickupDate":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpPickupDate($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpReturnDate":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpReturnDate($this->array[$i],$this->array[$j])){
                            $tmp = $this->array[$i];
                            $this->array[$i] = $this->array[$j];
                            $this->array[$j] = $tmp;
                        }
                    }
                }
                break;
            case "cmpPrice":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Datos a comparar Compare todos los datos anteriores, si los datos a comparar son menores que los datos a comparar, cambie la posición
                        if($this->cmpPrice($this->array[$i],$this->array[$j])){
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
        }
    } 
}
