<?php

require_once __DIR__.'/Repository.php';

/**
 * A specific repository for Users
 */
interface ReserveRepository extends Repository {
    
    /**
     * Returns an user entity from the repository given its email.
     * @param string $email User's email.
     * @return Reserve or null
     */
   
   public function findByVehicleUserPickUptime($vehicle, $user, $pickUpTime);

   //FindbyUser and vehicle y pickup

}