<?php

namespace easyrent\includes\service;

use easyrent\includes\persistance\repository\MysqlVehicleRepository;
use easyrent\includes\persistance\entity\Vehicle;

/**
 * Vehicle Service class.
 *
 * It manages the logic of the vehicle's actions.
 */
class VehicleService {

    /**
     * @var MysqlVehicleRepository Vehicle repository
     */
    private $vehicleRepository;

/**
     * @var VehicleService Single instance of VehicleService class.
     */
    private static $instance;

    /**
     * Creates a VehicleService
     *
     * @param MysqlVehicleRepository $vehicleRepository Instance of an MysqlVehicleRepository
     * @return void
     */
    private function __construct() {
        $this->vehicleRepository = $GLOBALS['db_vehicle_repository'];
    }

    /**
     * Controls the Singleton Pattern of VehicleService class. If the instance of VehicleService class exists, returns it. If not, returns it after creting it.
     *
     * @return VehicleService $instance Single instance of VehicleService
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Persists a new vehicle into the system if the vehicle is not register before.
     *
     * @param string $vin Vehicle's VIN. Valid vehicle's vin.
     * @param string $licensePlate Vehicle's license plate. Valid vehicle's license plate.
     * @param string $model Vehicle's model. Valid vehicle's model.
     * @param string $state Vehicle's state. As it is recently registered, state is 'available'.
     * @return Vehicle|null Returns null when there is an already existing vehicle with the same $vin
     */
    public function createVehicle($vin, $licensePlate, $model, $state) {
        $referenceVehicle = $this->vehicleRepository->findById($vin);
        if ($referenceVehicle === null) {
            $vehicle = new Vehicle($vin, $licensePlate, $model, $state);
            return $this->vehicleRepository->save($vehicle);
        }
        return null;
    }

    public function updateVehicle($vehicle) {
        return $this->vehicleRepository->save($vehicle);
    }

    /**
     * Deletes a vehicle from the system given the VIN.
     *
     * @param string $vin Vehicle's identification number.
     * @return bool
     */
    public function deleteVehicleByVin($vin) {
        return $this->vehicleRepository->deleteById($vin);
    }


    /**
     * Returns all the vehicles in the system.
     *
     * @return Vehicle[] Returns the vehicles from the database.
     */
    public function readAllVehicles(){
        return $this->vehicleRepository->findAll();
    }

    /**
     * Returns all the vehicles vin in the system.
     *
     * @return Vehicle[] Returns the vehicles vin from the database.
     */
    public function readAllVehiclesVIN(){
        return $this->vehicleRepository->findAllVin();
    }

    /**
     * Returns the vehicle by its vin
     *
     * @return Vehicle|null Returns null when there is not an existing vehicle with the same $vin
     */
    public function readVehicleByVin($vin){
        return $this->vehicleRepository->findById($vin);
    }

    /**
     * Returns the vehicle by its model
     *
     * @return Vehicle[]|null Returns null when there is not an existing vehicle with the same $model
     */
    public function readVehiclesByModel($model){
        return $this->vehicleRepository->findByModel($model);
    }

    /**
     * Returns all the vehicles in the system in the given location.
     *
     * @return Vehicle[] Returns the vehicles from the database.
     */
    public function readAllVehiclesInLocation($location){
        return $this->vehicleRepository->findAllbyLocation($location);
    }
}