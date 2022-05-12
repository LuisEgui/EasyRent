<?php

/**
 * Class for Reserve entity.
 */
class Reserve {

    private $id;

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

    const TYPES_STATE = [self::RESERVED => 'Reservado', self::PENDING => 'Pendiente'];   
    
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
     * @param float $price Reserve's price
     * @return void
     */
    public function __construct($id = null, $vehicle, $user, $state, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price) {
        $this->id = intval($id);
        $this->vehicle = intval($vehicle);
        $this->user = intval($user);
        $this->state = $state;
        $this->pickupLocation = $pickupLocation;
        $this->returnLocation = $returnLocation;
        $this->pickupTime = $pickupTime;
        $this->returnTime = $returnTime;
        $this->price = floatval($price);
    }

    public static function getStringEnumState($enum) {
        if ($enum < sizeof(self::TYPES_STATE) && $enum >= 0)
            return self::TYPES_STATE[$enum];
        else
            return null;
    }

    /**
     * Returns reserve's id
     * @return string id
     */
    public function getId() {
        return $this->id;
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
     * Returns reserve's pickUpLocation
     * @return string pickUpLocation
     */
    public function getPickUpLocation()
    {
        return $this->pickupLocation;
    }
    
    /**
     * Returns reserve's returnLocation
     * @return string returnLocation
     */
    public function getReturnLocation()
    {
        return $this->returnLocation;
    }
    
    /**
     * Returns reserve's pickUpTime
     * @return  datetime pickUpTime
     */
    public function getPickUpTime()
    {
        return $this->pickupTime;
    }
    
    /**
     * Returns reserve's return Time
     * @return  datetime returnocation
     */
    public function getReturnTime()
    {
        return $this->returnTime;
    }
    
    /**
     * Returns reserve's price
     * @return  float price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets reserve's id
     * @param $id Reserve's unique id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Sets reserve´s vehicle
     * @param mediumint $vehicle vehicle´s id
     * @return void
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }
    
    /**
     * Sets reserve´s user
     * @param mediumint $user user´s id who made the reserve
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    /**
     * Sets reserve´s pickUpLocation
     * @param string $pickUpLocation reserve´s pickUpLocation
     * @return void
     */
    public function setPickUpLocation($pickupLocation)
    {
        $this->pickupLocation = $pickupLocation;
    }
    
    /**
     * Sets reserve´s pickUpTime
     * @param datetime $pickUpTime reserve´s pickUpTime
     * @return void
     */

    public function setPickUpTime($pickUpTime)
    {
        $this->pickupTime = $pickUpTime;
    }
        /**
     * Sets reserve´s pickUpLocation
     * @param string $returnLocation reserve´s returnLocation
     * @return void
     */
    public function setReturnLocation($returnLocation)
    {
        $this->returnLocation = $returnLocation;
    }
    
    /**
     * Sets reserve´s returnTime
     * @param datetime $returnTime reserve´s returnTimme
     * @return void
     */
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime;
    }
    
    /**
     * Sets reserve´s state
     * @param string $state reserve´s state
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * Sets reserve´s price
     * @param float $price reserve´s price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
}