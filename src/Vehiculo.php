<?php

namespace ClaseVehiculo;

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

    const TYPES_STATE = [self::AVAILABLE => 'Disponible', self::UNAVAILABLE => 'No disponible', self::RESERVED => 'Reservado'];

    public static function getStringEnumState($enum){
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0){
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }

    const DIESEL = 0;
    const ELECTRIC-HYBRID = 1;
    const ELECTRIC = 2;
    const PETROL = 3;
    const PLUG-IN-HYBRID = 4;

    const TYPES_STATE = [self::DIESEL => 'Diesel', self::ELECTRIC-HYBRID => 'Hibrido', self::ELECTRIC => 'Electrico', self::PETROL => 'Gasolina', self::PLUG-IN-HYBRID => 'Hibrido enchufable'];

    public static function getStringEnumState($enum){
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0){
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }

    public static function crea($vin, $licensePlate, $model, $fuelType, $seatCount)
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
        /*if (!array_key_exists($state, self::TYPES_STATE)) {
            throw new Exception("$state no es un tipo de acceso válido");
        }*/
        $this->state = intval($state);
    }

    private static function getVehiculos($opciones = array())
    { //puedo pasar 
        $result = [];

        //real_escape_string() con TODOS los parametros q llegan desde opciones
        $conn = BD::getInstance()->getConexionBd();

        $query = 'SELECT * FROM Vehicle';

        if(!empty($opciones)){
            $query .= 'WHERE ';
            $contadorFiltros = 0;
            foreach ($opciones as $columna => $valor){
                if($columna != null && $contadorFiltros == 0){
                    $query .= $columna.' = '.$valor;
                }
                else if($columna != null && $contadorFiltros > 0){
                    $query .= 'AND '.$columna.' = '.$valor;
                }
                $contadorFiltros++;
            }
        }

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Vehiculo($fila['vin'], $fila['licensePlate'], $fila['model'], $fila['fuelType'], $fila['seatCount']);
            } // para que puedo querer devolver este resultado??
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

    /*public static function buscarPorVin($vin)
    {
        return self::getVehiculos($vin);
    }

    public static function buscarPorLicensePlate($licensePlate)
    {
        return self::getVehiculos(null, $licensePlate);
    }*/

    public static function buscaPorFiltros($opciones = array())
    {
        return self::getVehiculos($opciones);
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