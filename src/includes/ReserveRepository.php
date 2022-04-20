<?php

require_once RAIZ_APP.'/Repository.php';

/**
 * A specific repository for Users
 */
interface ReserveRepository extends Repository {
    
    /**
     * Returns an reserve entity from the repository given its primary key: vehicle, user, pickup time.
     * @param string $vehicle Vehicle's identification number (vin)
     * @param User $user User's id.
     * @param string $pickUpTime Reserve's pickup time
     * @return Reserve or null
     */
    public function findByVehicleAndUserAndPickUptime($vehicle, $user, $pickUpTime);

}