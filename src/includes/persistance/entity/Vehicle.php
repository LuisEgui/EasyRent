<?php

namespace easyrent\includes\persistance\entity;

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
     * @param string $vin Unique vehicle identifier (vin = vehicle identification number)
     * @param string $licensePlate Unique vehicle email
     * @param string $model Vehicle model
     * @param string $image Vehicle image
     * @param string $fuelType Vehicle fuel type. Possible values: 'diesel', 'electric-hybrid', 'electric', 'petrol', 'plug-in-hybrid'.
     * @param string $seatCount Vehicle seat count
     * @param string $state Vehicle state. Possible values: 'available', 'unavailable', 'reserved'.
     * @return void
     */
    public function __construct($vin, $licensePlate, $model, $image = null, $fuelType, $seatCount, $state = 'available')
    {
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->model = $model;
        $this->image = $image;
        $this->fuelType = $fuelType;
        $this->seatCount = $seatCount;
        $this->state = $state;
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
     * Returns vehicle's image
     * @return string image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Returns vehicle's fuelType
     * @return string fuelType
     */
    public function getFuelType()
    {
        return $this->fuelType;
    }

    /**
     * Returns vehicle's seatCount
     * @return string seatCount
     */
    public function getSeatCount()
    {
        return $this->seatCount;
    }

    /**
     * Returns vehicle's state
     * @return string state
     */
    public function getState()
    {
        return $this->state;
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
     * @param string $model
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Sets vehicle's image
     * @param string $image Image ID
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Sets vehicle's fuel type
     * @param string $fuelType
     * @return void
     */
    public function setFuelType($fuelType)
    {
        $this->fuelType = $fuelType;
    }

    /**
     * Sets vehicle's seat count
     * @param string $seatCount
     * @return void
     */
    public function setSeatCount($seatCount)
    {
        $this->seatCount = $seatCount;
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
