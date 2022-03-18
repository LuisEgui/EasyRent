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
        $vehiculo = new Vehiculo($vin, $licensePlate, $model, $fuelType, $seatCount, self::AVAILABLE);
        return $vehiculo;
    }

    public function __construct($vin, $licensePlate, $model, $fuelType, $seatCount, $state){
        //hay que asegurarse de que las variables enumeradas toman los valores permitidos y eso se hace antes de llamar a la funcion crea()
        $this->vin = intval($vin);
        $this->licensePlate = $licensePlate;
        $this->model = intval($model);
        $this->fuelType = intval($fuelType);
        $this->seatCount = intval($seatCount);
        $this->state = intval($state);
    }

    private static function getVehiculos($opciones = array())
    { //puedo pasar 
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();

        $query = 'SELECT * FROM Vehicle';

        if(!empty($opciones)){
            if($array_key_exists($key, $opciones))
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
            }
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result; 
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

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount, state) VALUES ('%d', '%s', '%d', %d, %d, %d)",
            $vehiculo->vin,
            $conn->real_escape_string($vehiculo->licensePlate), 
            $vehiculo->model,
            $vehiculo->fuelType,
            $conn->real_escape_string($vehiculo->seatCount),
            $vehiculo->state
        );

        $result = $conn->query($query);
        if ($result) {
            error_log("Se han insertado '$conn->affected_rows' !");
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
            "UPDATE Vehicle SET licensePlate = '%s', model = '%d', fuelType = '%d', seatCount = '%d', state = '%d' WHERE vin = %d",
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
        $query = sprintf("DELETE FROM Vehicle WHERE vin = '%d'", intval($vinVehiculo));
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }
}