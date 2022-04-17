<?php

require_once __DIR__.'/Repository.php';

/**
 * A specific repository for Users
 */
interface UserRepository extends Repository {
    
    /**
     * Returns an user entity from the repository given its email.
     * @param string $email User's email.
     * @return User or null
     */
    public function findByEmail($email);

}