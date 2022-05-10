<?php

/**
 * Class for damage entity.
 */
class Damage {

    /**
     * @var string Unique id damage identifier
     */
    private $d_id;

    /**
     * @var string Damages's unique vehicle's identifier
     */
    private $vehicle;

    /**
     * @var string user's unique identifier.
     */
    private $user;

    /**
     * @var string Damage's title.
     */
    private $title;

    /**
     * @var string Damage's description.
     */
    private $description;

    /**
     * @var string Damage's area.
     */
    private $area;

     /**
     * @var string Damage's type.
     */
    private $type;

    /**
     * @var boolean Damage's isRepaired.
     */
    private $isRepaired;

    /**
     * @var string Damage's image.
     */
    private $evidenceDamage;

    /**
     * @var string Damage's image
     */
    private $image;

    /**
     * @var string Damage time stamp
     */
    private $timeStamp;

    /**
     * Creates an Damage
     * 
     * @param string $Unique id damage identifier
     * @param string $Damages's unique vehicle's identifier
     * @param string $user's unique identifier.
     * @param string $Damage's title.
     * @param string $Damage's description.
     * @param string $Damage's evidenceDamage. Image of the damage.
     * @param string $Damage's area.
     * @param string $Damage's type.
     * @param boolean $Damage's isRepaired.
     * @param string $timeStamp Damage's time of insertion or update
     * @return Damage
     */
    public function __construct($id = null, $vehicle, $user, $title, $description, $evidenceDamage, $area, $type, $isRepaired, $timeStamp = null) {
        $this->d_id = $id;
        $this->vehicle = $vehicle;
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->evidenceDamage =$evidenceDamage;
        $this->area =$area;
        $this->type = $type;
        $this->isRepaired = $isRepaired;
        $this->timeStamp = $timeStamp;
    }

    /**
     * Returns damage's id
     * @return string d_id
     */

    public function getId() {
        return $this->d_id;
    }

    /**
     * Returns damage's vehicle
     * @return string vehicle
     */
    public function getVehicle() {
        return $this->vehicle;
    }

    /**
     * Returns damage's user 
     * @return string user
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Returns damage´s description
     * @return string description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Returns damage's title
     * @return string title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Returns damage's evidence
     * @return string evidence
     */
    public function getEvidenceDamage() {
        return $this->evidenceDamage;
    }
    
    /**
     * Returns damage's area
     * @return string area
     */
    public function getArea() {
        return $this->area;
    }

    /**
     * Returns damage's type
     * @return string type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Returns damage's isRepaired
     * @return boolean isRepaired
     */
    public function getIsRepaired() {
        return $this->isRepaired;
    }

    /**
     * Returns damage's timeStamp
     * @return string timeStamp
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Sets damage's id
     * @param string id
     * @return void
     */
    public function setId($d_id) {
        $this->id = $d_id;
    }

    /**
     * Sets damages's vehicle
     * @param string vehicle
     * @return void
     */
    public function setVehicle($vehicle) {
        $this->vehicle = $vehicle;
    }

    /**
     * Sets damage's user
     * @param string user
     * @return void
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Sets damage's title
     * @param string tile
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Sets damage's description 
     * @param string description 
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

     /**
     * Sets damage's evidence
     * @param string evidence
     * @return void
     */
    public function setEvidenceDamage($evidenceDamage) {
        $this->id = $evidenceDamage;
    }

    /**
     * Sets damage's area
     * @param string area
     * @return void
     */
    public function setArea($area) {
        $this->area = $area;
    }

    /**
     * Sets damage's type
     * @param string type
     * @return void
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * Sets damage's isRepaired
     * @param boolean isRepaired
     * @return void
     */
    public function setIsRepaired($isRepaired) {
        $this->isRepaired = $isRepaired;
    }

}
