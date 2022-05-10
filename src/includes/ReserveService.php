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
        $this->reserveRepository = $reserveRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
    }

    public function validateReserve($vin, $pickUpTime, $returnTime, $id) {
        if($pickUpTime >= $returnTime) return false;
        if($returnTime <= $pickUpTime) return false;
        $reservas = $this->reserveRepository->findAllByVin($vin);
        for($i = 0; $i < count($reservas); $i++) {
            if(($id !== null) && ($id === $reservas[$i]->getId())) $i++;
            
            if(($reservas[$i]->getPickUpTime() < $pickUpTime) && ($reservas[$i]->getReturnTime() > $pickUpTime)) return false;
            if(($reservas[$i]->getPickUpTime() < $returnTime) && ($reservas[$i]->getReturnTime() > $returnTime)) return false;
            if(($pickUpTime < $reservas[$i]->getPickUpTime()) && ($reservas[$i]->getReturnTime() < $returnTime)) return false;
        }
        return true;
    }
    /**
     * Persists a new reserve into the system
     * 
     * @param string $vin Unique vehicle identifier (vin = vehicle identification number) 
     * @param string $usuario User id
     * @param string $state Reserve state. Possible values: 'reserved', 'pending', 'cancelled'.
     * @param string $pickupLocation Reserve pickup location
     * @param string $returnLocation Reserve return location
     * @param string $pickupTime Reserve vehicle pickup time
     * @param string $returnTime Reserve vehicle return time
     * @param float $price Reserve's price
     * @return Reserve|null Returns null when there is an already existing reserve with the same $vehicle, logged user and $pickupTime
     */
    public function createReserve($vin, $idusuario, $state, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price) {
        $vehicle = $this->vehicleRepository->findById($vin);
        $validReserve = $this->validateReserve($vin, $pickupTime, $returnTime, null);
        if ($validReserve) {
            $reserve = new Reserve(null, $vin, $idusuario,
                            $state, $pickupLocation, $returnLocation, 
                            $pickupTime, $returnTime, $price);
            return $this->reserveRepository->save($reserve);
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

    public function getAllByVin($vin) {
        return $this->reserveRepository->findAllByVin($vin);
    }

    public function updateReserveReturnLocation($id, $newReturnLocation) {
        $reserve = $this->reserveRepository->findById($id);
        $reserve->setReturnLocation($newReturnLocation);
        $this->reserveRepository->save($reserve);
        return true;
    }

    public function updateReservePickupTime($id, $newPickupTime) {
        $reserve = $this->reserveRepository->findById($id);
        $validReserve = $this->validateReserve($reserve->getVehicle(), $newPickupTime, $reserve->getReturnTime(), $id);
        if(!$validReserve) return false;
        if($newPickupTime > $reserve->getReturnTime()) return false;
        $reserve->setPickUpTime($newPickupTime);
        $this->reserveRepository->save($reserve);
        return true;
    }

    public function updateReserveReturnTime($id, $newReturnTime) {
        $reserve = $this->reserveRepository->findById($id);
        $validReserve = $this->validateReserve($reserve->getVehicle(), $reserve->getPickUpTime(), $newReturnTime, $id);
        if(!$validReserve) return false;
        if($newReturnTime < $reserve->getPickUpTime()) return false;
        $reserve->setReturnTime($newReturnTime);
        $this->reserveRepository->save($reserve);
        return true;
    }

    public function updateReserveVehicle($id, $newVehicle) {
        $reserve = $this->reserveRepository->findById($id);
        $validReserve = $this->validateReserve($newVehicle, $reserve->getPickUpTime(), $reserve->getReturnTime(), $id);
        if(!$validReserve) return false;
        $reserve->setVehicle($newVehicle);
        $this->reserveRepository->save($reserve);
        return true;
    }
    
    public function updateReservePrice($id, $newPrice) {
        $reserve = $this->reserveRepository->findById($id);
        $reserve->setPrice($newPrice);
        $this->reserveRepository->save($reserve);
        return true;
    }
    
    public function deleteReserve($id) {
        $this->reserveRepository->deleteById($id);
        return true;
    }

    public function confirmReserve($id) {
        $reserve = $this->reserveRepository->findById($id);
        $reserve->setState('reserved');
        $this->reserveRepository->save($reserve);
        return true;
    }

    public function getLicensePlate($vin){
        $vehicle = $this->vehicleRepository->findById($vin);
        return $vehicle->getLicensePlate();
    }
}