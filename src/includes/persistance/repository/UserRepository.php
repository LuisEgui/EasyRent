<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\User;

/**
 * A specific repository for Users
 */
interface UserRepository extends Repository {

    /**
     * Returns an user entity from the repository given its email.
     * @param string $email User's email.
     * @return User|null
     */
    public function findByEmail($email);

}
