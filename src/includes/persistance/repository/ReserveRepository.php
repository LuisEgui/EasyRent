<?php

namespace easyrent\includes\persistance\repository;

/**
 * A specific repository for Users
 */
interface ReserveRepository extends Repository {
    
    /**
     * Returns an reserve entity from the repository given its primary key: vehicle, user, pickup time.
     * @param string $vehicle Vehicle's identification number (vin)
     * @param User $user User's id.
     * @param string $pickUpTime Reserve's pickup time
     * @return Reserve|null
     */
    public function findByVehicleAndUserAndPickUptime($vehicle, $user, $pickUpTime);

    /**
     * Returns all reserves from the repository given an user
     * @param user $user User's id
     * @return mixed|null
     */
    public function findAllByUser($user);

    /**
     * Returns all reserves from the repository given a vin
     * @param string $vin Vehicles's vin
     * @return mixed|null
     */
    public function findAllByVin($vin);

}