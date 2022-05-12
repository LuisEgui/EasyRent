<?php

namespace easyrent\includes\persistance\repository;

/**
 * A specific repository for Damages
 */
interface DamageRepository extends Repository {

    public function findByVehicle($vehicle);

}