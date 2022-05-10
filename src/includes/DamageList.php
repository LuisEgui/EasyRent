<?php

/**
 * Class for damageList entity.
 */
class DamageList
{
    /**
     * @var string DamageList array list
     */
    private $array;

    /**
     * Creates a DamageList
     *
     * @param string $array array list
     * @return void
     */
    public function __construct($array = array())
    {
        $this->array = $array;
    }

    /**
     * Returns damageList's array
     * @return array array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Sets damageList's array
     * @param array $array array of damages
     * @return void
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    private function cmpID($a, $b)
    {
        return ($a->getId() < $b->getId()) ? 1 : 0;
    }

    private function cmpVehicle($a, $b)
    {
        return ($a->getVehicle() < $b->getVehicle()) ? 1 : 0;
    }

    private function cmpUser($a, $b)
    {
        return ($a->getUser() < $b->getUser()) ? 1 : 0;
    }

    private function cmpType($a, $b)
    {
        return ($a->getType() < $b->getType()) ? 1 : 0;
    }

    private function cmpIsRepaired($a, $b)
    {
        return ($a->getIsRepaired() < $b->getIsRepaired()) ? 1 : 0;
    }

    private function cmpFecha($a, $b)
    {
        return ($a->getTimeStamp() < $b->getTimeStamp()) ? 1 : 0;
    }

    function orderBy($function){
        $len = count($this->array);
        switch ($function) {
            case "cmpBrand":
                for ($i=0;$i<$len;$i++){
                    for($j=0;$j<$i;$j++){
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
                        //Compara todos los datos anteriores, si el dato i es menor que los datos a comparar, cambia la posición
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
