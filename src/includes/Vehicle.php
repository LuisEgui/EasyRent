<?php

/**
 * Class for user entity.
 */
class Vehicle {

    /**
     * @var string Unique vehicle identifier
     */
    private $vin;

    /**
     * @var string Unique vehicle license plate
     */
    private $licensePlate;

    /**
     * @var string Vehicle model
     */
    private $model;

    /**
     * @var string Vehicle image
     */
    private $image;

    /**
     * @var string Vehicle fuel type.
     */
    private $fuelType;

    /**
     * @var string Vehicle seat count.
     */
    private $seatCount;

    /**
     * @var string Vehicle state.
     */
    private $state;

    /**
     * Creates a Vehicle
     * 
     * @param string $vin Unique vehicle identifier
     * @param string $licensePlate Unique vehicle email
     * @param string $model Vehicle model
     * @param string $image Vehicle image
     * @param string $fuelType Vehicle fuel type. Possible values: 'diesel', 'electric-hybrid', 'electric', 'petrol', 'plug-in-hybrid'.
     * @param string $seatCount Vehicle seat count
     * @param string $state Vehicle state. Possible values: 'available', 'unavailable', 'reserved'.
     * @return Vehicle
     */
    public function __construct($vin, $licensePlate, $model, $image, $fuelType, $seatCount, $state = 'available') {
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->model = $model;
        $this->image = $image
        $this->fuelType = $fuelType;
        $this->seatCount = $seatCount;
        $this->state = $state;
    }

    /**
     * Returns vehicle's vin
     * @return string vin
     */
    public function getVin() {
        return $this->vin;
    }

    /**
     * Returns vehicle's licensePlate
     * @return string licensePlate
     */
    public function getLicensePlate() {
        return $this->licensePlate;
    }

    /**
     * Returns vehicle's model
     * @return string model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Returns vehicle's image
     * @return string image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Returns vehicle's fuelType
     * @return string fuelType
     */
    public function getFuelType() {
        return $this->fuelType;
    }

     /**
     * Returns vehicle's seatCount
     * @return string seatCount
     */
    public function getSeatCount() {
        return $this->seatCount;
    }

     /**
     * Returns vehicle's state
     * @return string state
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Sets vehicle's vin
     * @param string $vin Vehicle vin
     * @return void
     */
    public function setVin($vin) {
        $this->vin = $vin;
    }

    /**
     * Sets vehicle's license plate
     * @param string $licensePlate Vehicle licensePlate
     * @return void
     */
    public function setLicensePlate($licensePlate) {
        $this->licensePlate = $licensePlate;
    }

    /**
     * Sets vehicle's model
     * @param string $model
     * @return void
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * Sets vehicle's image
     * @param string $image Image ID
     * @return void
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * Sets vehicle's fuel type
     * @param string $fuelType
     * @return void
     */
    public function setFuelType($fuelType) {
        $this->fuelType = $fuelType;
    }

    /**
     * Sets vehicle's seat count
     * @param string $seatCount
     * @return void
     */
    public function setSeatCount($seatCount) {
        $this->seatCount = $seatCount;
    }

    /**
     * Sets vehicle's state
     * @param string $state
     * @return void
     */
    public function setState($state) {
        $this->state = $state;
    }

    /**
     * Check if an user has a determined role
     * 
     * @param string $role Check if the user has this role.
     * @return bool
     * 
     * public function hasRole($role) {
     *    return ($this->role === $role) ? true : false;
     * }
     */
    

}
--------------------------------------------------------------------------------------------------
class Vehiculo{
    //use MagicProperties;

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
    const ELECTRIC_HYBRID = 1;
    const ELECTRIC = 2;
    const PETROL = 3;
    const PLUG_IN_HYBRID = 4;

    /*const TYPES_STATE = [ 'Diesel' => self::DIESEL, self::ELECTRIC_HYBRID => 'Hibrido', self::ELECTRIC => 'Electrico', self::PETROL => 'Gasolina', self::PLUG_IN_HYBRID => 'Hibrido enchufable'];

    public static function getStringEnumState($enum){
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0){
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }*/

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
        $this->fuelType = $fuelType;
        $this->seatCount = intval($seatCount);
        $this->state = $state;
    }

    private static function getVehiculos($opciones = array())
    { 
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();

        $query = 'SELECT * FROM Vehicle';

        if(!empty($opciones)){
            if($array_key_exists('licensePlate', $opciones)){
                $opciones['licensePlate'] = $conn->real_escape_string($opciones['licensePlate']);
            }
            $query .= 'WHERE ';
            $contadorFiltros = 0;
            foreach ($opciones as $columna => $valor){
                if($contadorFiltros == 0){
                    $query .= $columna.' = '.$valor;
                }
                else if($contadorFiltros > 0){
                    $query .= 'AND '.$columna.' = '.$valor;
                }
                $contadorFiltros++;
            }
        }

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Vehiculo($fila['vin'], $fila['licensePlate'], $fila['model'], $fila['fuelType'], $fila['seatCount'], $fila['state']);
            }
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result; 
    }

    public static function buscaPorFiltros($opciones = array())
    {
        return self::getVehiculos($opciones);
    }

    public static function inserta($vehiculo)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount) VALUES (%d, '%s', %d, %d, %d)",
            $vehiculo->vin,
            $conn->real_escape_string($vehiculo->licensePlate), 
            $vehiculo->model,
            $vehiculo->fuelType,
            $vehiculo->seatCount
        );

        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han insertado '$conn->affected_rows' !");
        }
        return $result;
    }

    private static function actualiza($vehiculo)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Vehicle SET licensePlate = '%s', model = %d, fuelType = %d, seatCount = %d, state = %d WHERE vin = %d",
            $conn->real_escape_string($vehiculo->licensePlate), 
            $vehiculo->model,
            $vehiculo->fuelType,
            $vehiculo->seatCount,
            $vehiculo->state,
            $vehiculo->vin,
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han actualizado '$conn->affected_rows' !");
        }
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
            error_log(__CLASS__ . ": Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public function getVin()
    {
        return $this->vin;
    }
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }
    public function getModel()
    {
        return $this->model;
    }
    public function getFuelType()
    {
        return $this->fuelType;
    }
    public function getSeatCount()
    {
        return $this->seatCount;
    }
    public function getState()
    {
        return $this->state;
    }

    public function setLicensePlate($licPlate)
    {
        $this->licensePlate = $licPlate;
    }
    public function setModel($model)
    {
        $this->model = $model;
    }
    public function setFuelType($fuelT)
    {
        $this->fuelType = $fuelT;
    }
    public function setSeatCount($seatC)
    {
        $this->seatCount = $seatC;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
}