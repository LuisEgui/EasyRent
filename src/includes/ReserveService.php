<?php

require __DIR__.'/MysqlUserRepository.php';
require __DIR__.'/MysqlImageRepository.php';

/**
 * Reserve Service class.
 * 
 * It manages the logic of the reserve's actions. 
 */
class ReserveService {

    /**
     * @var ReserveRepository Reserve repository
     */
    private $reserveRepository;


    /**
     * Creates an ReserveService
     * 
     * @param ReserveRepository $reserveRepository Instance of an ReserveRepository
     * @return void
     */
    public function __construct(reserveRepository $reserveRepository) {
        $this->reserve = $reserveRepository;
       
    }

    /

   

    

    /**
     * Persists a new user into the system if the user is not register before.
     * 
     * @param string $email User's email. Valid user's email.
     * @param string $password User's password. No requirements on this string.
     * @param string $role User's role. Valid roles are: 'particular', 'enterprise' and 'admin'.
     * @return User|null Returns null when there is an already existing user with the same $email
     */
    public function createReserve($email, $password, $role) {
        $referenceUser = $this->userRepository->findByEmail($email);
        if ($referenceUser === null) {
            $user = new User(null, $email, self::hashPassword($password), $role, null);
            return $this->userRepository->save($user);
        }
        return null;
    }

    public function readAllReserves(){
        return $this->reserveRepository->reservasPersonales();
    }


     







   