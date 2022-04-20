<?php

/**
 * Class for Reserve entity.
 */
class Reserve {

    /**
     * @var string Unique vehicle identifier
     */
	private $vehicle;

    /**
     * @var string Unique user identifier
     */
    private $user;

    /**
     * @var string Reserve state
     */
    private $state;

    /**
     * @var string Reserve vehicle pickup location
     */
    private $pickupLocation;

    /**
     * @var string Reserve vehicle return location
     */
    private $returnLocation;

    /**
     * @var string Reserve vehicle pickup time
     */
    private $pickupTime;

    /**
     * @var string Reserve vehicle return time
     */
    private $returnTime;

    /**
     * @var string Reserve price
     */
    private $price;

    const RESERVED = 0;
    const PENDING = 1;
    const CANCELLED = 2;

    const TYPES_STATE = [self::RESERVED => 'Reservado', self::PENDING => 'Pendiente', self::CANCELLED => 'Cancelada'];   

    /**
     * Creates a Reserve
     * 
     * @param string $vehicle Unique vehicle identifier (vin = vehicle identification number)
     * @param string $user Unique user id
     * @param string $state Reserve state. Possible values: 'reserved', 'pending', 'cancelled'.
     * @param string $pickupLocation Reserve pickup location
     * @param string $returnLocation Reserve return location
     * @param string $pickupTime Reserve vehicle pickup time
     * @param string $returnTime Reserve vehicle return time
     * @return void
     */
    public function __construct($vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime, $returnTime,$price) {
        $this->vehicle = intval($vehicle);
        $this->user = $user;
        $this->state = intval($state);
        $this->pickupLocation = $pickupLocation;
        $this->returnLocation = intval($returnLocation);
        $this->pickupTime = $pickupTime;
        $this->returnTime = $returnTime;
        $this->price = $price;
    }

    public static function getStringEnumState($enum) {
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0) {
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }

    /**
     * Returns vehicle's id
     * @return string id
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Returns user's id
     * @return string id
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns reserve's state
     * @return string state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Returns reserve's state
     * @return string state
     */
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
    public function setState($state)
    {
        $this->state = $state;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
}