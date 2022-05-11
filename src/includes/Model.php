<?php

/**
 * Class for model entity.
 */
class Model
{

    /**
     * @var string Unique model identifier
     */
    private $m_id;

    /**
     * @var string Model brand
     */
    private $brand;

    /**
     * @var string Model name
     */
    private $model;

    /**
     * @var string Model submodel
     */
    private $submodel;

    /**
     * @var string Model gearbox
     */
    private $gearbox;

    /**
     * @var string Model category
     */
    private $category;

    /**
     * @var string Model fuel type.
     */
    private $fuelType;

    /**
     * @var string Model seat count.
     */
    private $seatCount;

    /**
     * @var string Model image
     */
    private $image;

    /**
     * @var string Model time stamp
     */
    private $timeStamp;

    /**
     * Creates a Model
     *
     * @param string $m_id Unique model identifier 
     * @param string $brand Model brand
     * @param string $model Model model
     * @param string $submodel Model submodel
     * @param string $gearbox Model gearbox. Possible values: 'Manual', 'Automatic', 'Semi-automatic', 'Duplex'.
     * @param string $category Model category. Possible values: 'Coupe', 'Pickup', 'Roadster', 'Sedan', 'Small-car', 'Suv', 'Van'.
     * @param string $fuelType Model fuel type. Possible values: 'Diesel', 'Electric-hybrid', 'Electric', 'Petrol', 'Plug-in-hybrid'.
     * @param string $seatCount Model seat count
     * @param string $image Model image
     * @param string $timeStamp Model time of insertion or update
     * @return void
     */
    public function __construct($m_id, $brand, $model, $submodel, $gearbox, $category, $fuelType, $seatCount, $image, $timeStamp = null)
    {
        $this->m_id = $m_id;
        $this->brand = $brand;
        $this->model = $model;
        $this->submodel = $submodel;
        $this->gearbox = $gearbox;
        $this->category = $category;
        $this->fuelType = $fuelType;
        $this->seatCount = $seatCount;
        $this->image = $image;
        $this->timeStamp = $timeStamp;
    }

    /**
     * Returns model's id
     * @return string m_id
     */
    public function getId()
    {
        return $this->m_id;
    }

    /**
     * Returns model's brand
     * @return string brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Returns model's name
     * @return string model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns model's submodel
     * @return string submodel
     */
    public function getSubmodel()
    {
        return $this->submodel;
    }

    /**
     * Returns model's gearbox
     * @return string gearbox
     */
    public function getGearbox()
    {
        return $this->gearbox;
    }

    /**
     * Returns model's category
     * @return string category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Returns model's fuelType
     * @return string fuelType
     */
    public function getFuelType()
    {
        return $this->fuelType;
    }

    /**
     * Returns model's seatCount
     * @return string seatCount
     */
    public function getSeatCount()
    {
        return $this->seatCount;
    }

     /**
     * Returns model's image
     * @return string image
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Sets model's m_id
     * @param string $m_id Model id
     * @return void
     */
    public function setId($m_id)
    {
        $this->m_id = $m_id;
    }

    /**
     * Sets model's brand
     * @param string $brand
     * @return void
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Sets model's name
     * @param string $model
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Sets model's submodel
     * @param string $submodel
     * @return void
     */
    public function setSubmodel($submodel)
    {
        $this->submodel = $submodel;
    }

    /**
     * Sets model's gearbox
     * @param string $gearbox
     * @return void
     */
    public function setGearbox($gearbox)
    {
        $this->gearbox = $gearbox;
    }

    /**
     * Sets model's category
     * @param string $category
     * @return void
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Sets model's fuel type
     * @param string $fuelType
     * @return void
     */
    public function setFuelType($fuelType)
    {
        $this->fuelType = $fuelType;
    }

    /**
     * Sets model's seat count
     * @param string $seatCount
     * @return void
     */
    public function setSeatCount($seatCount)
    {
        $this->seatCount = $seatCount;
    }

    /**
     * Sets model's image
     * @param string $image Image ID
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}