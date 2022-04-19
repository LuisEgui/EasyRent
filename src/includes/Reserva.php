<?php


require_once __DIR__.'\BD.php';
require_once __DIR__.'\User.php';

class Reserve{


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

   

    public function __construct($vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime,$returnTime,$price){
       
        $this->vehicle = intval($vehicle);
        $this->user = $user;
        $this->state = intval($state);
        $this->pickupLocation = $pickupLocation;
        $this->returnLocation = intval($returnLocation);
        $this->pickupTime = $pickupTime;
        $this->returnTime = $returnTime;
        $this->price = $price;
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