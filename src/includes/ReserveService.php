<?php

require __DIR__.'/MysqlReserveRepository.php';

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
     * @var Repository Reserve repository
     */
    private $vehicleRepository;

    /**
     * @var UserRepository Reserve repository
     */
    private $userRepository;

    /**
     * Creates an ReserveService
     * 
     * @param ReserveRepository $reserveRepository Instance of an ReserveRepository
     * @return void
     */
    public function __construct(ReserveRepository $reserveRepository, Repository $vehicleRepository, Repository $userRepository) {
        $this->reserve = $reserveRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Persists a new reserve into the system
     * 
     * @param string $vin Unique vehicle identifier (vin = vehicle identification number) 
     * @param string $state Reserve state. Possible values: 'reserved', 'pending', 'cancelled'.
     * @param string $pickupLocation Reserve pickup location
     * @param string $returnLocation Reserve return location
     * @param string $pickupTime Reserve vehicle pickup time
     * @param string $returnTime Reserve vehicle return time
     * @param float $price Reserve's price
     * @return Reserve|null Returns null when there is an already existing reserve with the same $vehicle, logged user and $pickupTime
     */
    public function createReserve($vin, $state, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price) {

        if (!isset($pickupTime))
            return null;
        
        $user = $this->userRepository->findByEmail($_SESSION['email']);
        $vehicle = $this->vehicleRepository->findById($vin);
        $referenceReserve = $this->reserveRepository->findByVehicleAndUserAndPickUptime($vin, $user, $pickupTime);

        if ($referenceReserve === null) {
            $reserve = new Reserve(null, $vehicle->getId(), $user->getId(),
                            $state, $pickupLocation, $returnLocation, 
                            $pickupTime, $returnTime, $price);
            return $this->userRepository->save($reserve);
        }
        return null;
    }

    public function getAllPersonalReserves() {
        $user = $this->userRepository->findByEmail($_SESSION['email']);
        return $this->reserveRepository->findAllByUser($user->getId());
    }

    public function getAllReserves() {
        return $this->reserveRepository->findAll();
    }

}