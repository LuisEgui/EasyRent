<?php

namespace easyrent\includes\persistance\entity;

use easyrent\includes\service\Model;

/**
 * Class for user entity.
 */
class Vehicle
{

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
     * @var string Vehicle location.
     */
    private $location;

    /**
     * @var string Vehicle state.
     */
    private $state;

    /**
     * @var string Vehicle time stamp
     */
    private $timeStamp;

    /**
     * Creates a Vehicle
     *
     * @param string $vin Unique vehicle identifier (vin = vehicle identification number)
     * @param string $licensePlate Unique vehicle email
     * @param string $model Vehicle model
     * @param string $location Vehicle location
     * @param string $state Vehicle state. Possible values: 'available', 'unavailable', 'reserved'.
     * @param string $timeStamp Vehicle time of insertion or update
     * @return void
     */
    public function __construct($vin, $licensePlate, $model, $location, $state = 'available', $timeStamp = null)
    {   
        
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->model = $model;
        $this->location = $location;
        $this->state = $state;
        $this->timeStamp = $timeStamp;
    }

    /**
     * Returns vehicle's vin
     * @return string vin
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Returns vehicle's licensePlate
     * @return string licensePlate
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }

    /**
     * Returns vehicle's model
     * @return string model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns vehicle's location
     * @return string location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Returns vehicle's state
     * @return string state
     */
    public function getState()
    {
        return $this->state;
    }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Sets vehicle's vin
     * @param string $vin Vehicle vin
     * @return void
     */
    public function setVin($vin)
    {
        $this->vin = $vin;
    }

    /**
     * Sets vehicle's license plate
     * @param string $licensePlate Vehicle licensePlate
     * @return void
     */
    public function setLicensePlate($licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }

    /**
     * Sets vehicle's model
     * @param string $model Model ID
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Sets vehicle's location
     * @param string $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->molocationdel = $location;
    }

    /**
     * Sets vehicle's state
     * @param string $state
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

}
