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

    private static function getVehiculos($vin = null, $licensePlate = null, $model = null, $fuelType = null, $seatCount = null, $state = null)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Vehicle';

        if($model !== null || $fuelType !== null || $seatCount !== null || $state !== null){
            $query .= 'WHERE '
        }

        $contadorFiltros = 0;

        if ($vin !== null) {
            $query .= sprintf('vin = %d', $vin);
            $contadorFiltros++;
        }
        if ($licensePlate !== null) {
            if($contadorFiltros > 0){
                $query .= sprintf(' AND licensePlate = %s', $licensePlate); // a lo mejor la matrícula es un string
            }
            else{
                $query .= sprintf('licensePlate = %s', $licensePlate);
            }
            $contadorFiltros++;
        }
        if ($model !== null) {
            if($contadorFiltros > 0){
                $query .= sprintf(' AND model = %d', $model);
            }
            else{
                $query .= sprintf('model = %d', $model);
            }
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

    public static function buscarPorVin($vin)
    {
        return self::getVehiculos($vin);
    }

    public static function buscarPorLicensePlate($licensePlate)
    {
        return self::getVehiculos(null, $licensePlate);
    }

    public static function buscaPorFiltros($model = null, $fuelType = null, $seatCount = null, $state = null)
    {
        return self::getVehiculos(null, null, $model, $fuelType, $seatCount, $state);
    }

	public function registrar($_params){
        $sql="INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount, state) 
        VALUES ('$vin', '$licensePlate', '$model', '$fuelType', '$seatCount', '$state')";
    }

    private static function inserta($vehiculo)
    {
        $result = false;
        $vehiculoInsertado = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount, state) VALUES ('%d', '%s', '%d', %d, %d, %d)",
            $vehiculo->vin, //y si son enteros, tb hay q pasarlos a string?
            $conn->real_escape_string($vehiculo->licensePlate), 
            $vehiculo->model,
            $vehiculo->fuelType,
            $conn->real_escape_string($vehiculo->seatCount),
            $vehiculo->state,
            //$imagen->tipoAcceso (enumerado) --> los enumerados se insertan así?
        );

        $result = $conn->query($query);
        if ($result) {
            //$vehiculoInsertado = mysql_fetch_object($result, 'Vehiculo'); //esta funcion funciona como queremos, que devuelva el vehiculo insertado con todas sus características, y es útil eso q queremos hacer?
            //quiero poner algo para comprobar que se ha insertado bienn
        } else {
            error_log($conn->error);
        }

        return $vehiculoInsertado;
    }

    private static function actualiza($vehiculo)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Vehicle SET licensePlate = '%s', model = '%d', fuelType = %d, seatCount = %d, state = %d WHERE vin = %d",
            $conn->real_escape_string($vehiculo->licensePlate), 
            $vehiculo->model,
            $vehiculo->fuelType,
            $conn->real_escape_string($vehiculo->seatCount),
            $vehiculo->state,
            $vehiculo->vin,
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han actualizado '$conn->affected_rows' !");
        }
        // de que vale el error log??
        return $result;
    }

    private static function borra($vehiculo)
    {
        return self::borraPorVin($vehiculo->vin);
    }

    private static function borraPorVin($vinVehiculo)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Vehicle WHERE vin = %d", intval($vinVehiculo));
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }
}