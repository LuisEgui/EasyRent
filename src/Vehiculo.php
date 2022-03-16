<?php

namespace FlejeMascarillas;

class Vehiculo{
	private $vin;
    private $licensePlate;
    private $model;
    private $fuelType;
    private $seatCount;
    private $state;

    const AVAILABLE = 0;

    const UNAVAILABLE = 1;

    const RESERVED = 2;

    const TYPES_STATE = [self::AVAILABLE, self::UNAVAILABLE, self::RESERVED];

    public static function crea($vin, $licensePlate, $model, $fuelType, $seatCount, $state)
    {
        $vehiculo = new Vehiculo($vin, $licensePlate, $model, $fuelType, $seatCount, $state = self::AVAILABLE);
        return $vehiculo;
    }

    public function __construct($vin, $licensePlate, $model, $fuelType, $seatCount, $state){
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->model = $model;
        $this->fuelType = $fuelType;
        $this->seatCount = $seatCount;
        if (!in_array($state, self::TYPES_STATE)) {
            throw new Exception("$state no es un tipo de acceso válido");
        }
        $this->state = intval($state);
    }

	public function registrar($_params){
        $sql="INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount, state) 
        VALUES ('$vin', '$licensePlate', '$model', '$fuelType', '$seatCount', '$state')";
    }

    private static function getVehiculos($model = null, $fuelType = null, $seatCount = null, $state = null)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Vehiculos';

        if($model !== null || $fuelType !== null || $seatCount !== null || $state !== null){
            $query .= 'WHERE '
        }

        $contadorFiltros = 0;

        if ($model !== null) {
            $query .= sprintf('model = %d', $model);
            $contadorFiltros++;
        }
        if ($fuelType !== null) {
            if($contadorFiltros > 0){
                $query .= sprintf(' AND fuelType = %d', $fuelType);
            }
            else{
                $query .= sprintf('fuelType = %d', $fuelType);
            }
            $contadorFiltros++;
        }
        if ($seatCount !== null) {
            if($contadorFiltros > 0){
                $query .= sprintf(' AND seatCount = %d', $seatCount);
            }
            else{
                $query .= sprintf('seatCount = %d', $seatCount);
            }
            $contadorFiltros++;
        }
        if ($state !== null) {
            if($contadorFiltros > 0){
                $query .= sprintf(' AND state = %d', $state);
            }
            else{
                $query .= sprintf('state = %d', $state);
            }
            $contadorFiltros++;
        }
        
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Vehiculo($fila['vin'], $fila['licensePlate'], $fila['model'], $fila['fuelType'], $fila['seatCount']);
            }
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    public static function listaVehiculos()
    {
        return self::getVehiculos();
    }

    public static function buscaPor($model = null, $fuelType = null, $seatCount = null, $state = null)
    {
        return self::getVehiculos($model, $fuelType, $seatCount, $state);
    }

    
}