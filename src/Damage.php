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
     * Creates an Damage
     * 
     * @param string $Unique id damage identifier
     * @param string $Damages's unique vehicle's identifier
     * @param string $user's unique identifier.
     * @param string $Damage's title.
     * @param string $Damage's description.
     * @param string $Damage's area.
     * 
     * @return Damage
     */
    public function __construct($id = null, $vehicle, $user, $title, $description, $evidenceDamage, $area) {
        $this->d_id = $id;
        $this->vehicle = $vehicle;
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->evidenceDamage =$evidenceDamage;
        $this->area =$area;
    }

   

    /**
     * Returns damages's id
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
     * Returns damages's user 
     * @return string user
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Returns damage´s description
     * @return string description
     */
    public function getdescription() {
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
     * Returns damages's evidence
     * @return string evidence
     */
    public function getEvidenceDamage() {
        return $this->evidenceDamage;
    }
    
       /**
     * Returns damages's area
     * @return string area
     */
    public function getArea() {
        return $this->area;
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
        $this->descrioption = $description;
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
    public function setaArea($area) {
        $this->area = $area;
    }

}
