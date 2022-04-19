<?php

//namespace ClaseVehiculo;
require_once __DIR__.'\BD.php';
require_once __DIR__.'\User.php';

class Reserve{
    //use MagicProperties;

	private $vehicle; //Identificador del vehiculo.
    private $user;
    private $state;
    private $pickupLocation;
    private $returnLocation;
    private $pickupTime;
    private $returnTime;
    private $price;

    const RESERVED = 0;
    const PENDING = 1;
    const CANCELLED = 2;

    const TYPES_STATE = [self::RESERVED => 'Reservado', self::PENDING => 'Pendiente', self::CANCELLED => 'Cancelada'];

    public static function getStringEnumState($enum){
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0){
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }

   

    public static function crea($vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime,$returnTime,$price)
    {
        $reserva = new Reserve($vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime,$returnTime,$price, self::RESERVED);
        return $reserva;
    }

    public function __construct($vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime,$returnTime,$price){
        //hay que asegurarse de que las variables enumeradas toman los valores permitidos y eso se hace antes de llamar a la funcion crea()
        $this->vehicle = intval($vehicle);
        $this->user = $user;
        $this->state = intval($state);
        $this->pickupLocation = $pickupLocation;
        $this->returnLocation = intval($returnLocation);
        $this->pickupTime = $pickupTime;
        $this->returnTime = $returnTime;
        $this->price = $price;
    }

    private static function getReservas()
    { 
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();

        $query = 'SELECT * FROM Reserve';

        $user = User::findUserByEmail($_SESSION['email']);

        if(!empty($opciones)){
            if($array_key_exists('user', $user)){
                $opciones['user'] = $conn->real_escape_string($opciones['user']);
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

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("select * from reserve where user=%d", $user->getId());
        $rs = $conn->query($query);

        if (mysqli_num_rows($rs) > 0) {
            while($row = mysqli_fetch_array($rs)) {
                $result[] = new Reserve($row['vehicle'], $row['user'], $row['state'], $row['pickupLocation'], $row['returnLocation'], $row['pickupTime'], $row['returnTime'], $row['price']);
            }
        } else
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        return $result;
    }


    public static function reservasPersonales()
    {
        return self::getReservas();
    }

    public function getVehicle()
    {
        return $this->vehicle;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getPickUpLocation()
    {
        return $this->pickupLocation;
    }
    public function getReturnLocation()
    {
        return $this->returnLocation;
    }
    public function getPickUpTime()
    {
        return $this->pickupTime;
    }
    public function getReturnTime()
    {
        return $this->returnTime;
    }
    public function getPrice()
    {
        return $this->price;
    }



    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
    public function setPickUpLocation($pickupLocation)
    {
        $this->pickupLocation = $pickupLocation;
    }
    public function setPickUpTime($pickUpTime)
    {
        $this->pickupTime = $pickUpTime;
    }
    public function setReturnLocation($returnLocation)
    {
        $this->returnLocation = $returnLocation;
    }
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime;
    }
    public function setstate($state)
    {
        $this->state = $state;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
}