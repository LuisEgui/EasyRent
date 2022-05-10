<?php

namespace easyrent\includes\service;

use easyrent\includes\persistance\entity\Image;
use easyrent\includes\persistance\entity\Vehicle;
use easyrent\includes\persistance\repository\MysqlVehicleRepository;
use easyrent\includes\persistance\repository\Repository;

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
     * @var Repository Image repository
     */
    private $imageRepository;

    /**
     * Creates a VehicleService
     *
     * @param MysqlVehicleRepository $vehicleRepository Instance of an MysqlVehicleRepository
     * @param Repository $imageRepository Instance of an MysqlImageRepository
     * @return void
     */
    public function __construct(MysqlVehicleRepository $vehicleRepository, Repository $imageRepository) {
        $this->vehicleRepository = $vehicleRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Persists a new vehicle into the system if the vehicle is not register before.
     *
     * @param string $vin Vehicle's VIN. Valid vehicle's vin.
     * @param string $licensePlate Vehicle's license plate. Valid vehicle's license plate.
     * @param string $model Vehicle's model. Valid vehicle's model.
     * @param string $fuelType Vehicle's fuel type. Valid roles are: 'diesel', 'ehybrid', 'hybrid', 'petrol', 'plugInHybrid'.
     * @param string $seatCount Vehicle's seat count. Valid vehicle's seat count.
     * @param string $state Vehicle's state. As it is recently registered, state is 'available'.
     * @return Vehicle|null Returns null when there is an already existing vehicle with the same $vin
     */
    public function createVehicle($vin, $licensePlate, $model, $fuelType, $seatCount, $state) {
        $referenceVehicle = $this->vehicleRepository->findById($vin);
        if ($referenceVehicle === null) {
            $vehicle = new Vehicle($vin, $licensePlate, $model, null, $fuelType, $seatCount, $state);
            return $this->vehicleRepository->save($vehicle);
        }
        return null;
    }

    /**
     * Deletes a vehicle from the system given the VIN.
     *
     * @param string $vin Vehicle's identification number.
     * @return bool
     */
    public function deleteVehicle($vin) {
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
     * Checks if the current user is an admin in the system, at the moment of the
     * call to this function.
     * @return bool
     */
    private function isAdmin() {
        return isset($_SESSION['esAdmin']) && isset($_SESSION['login']);
    }

    /**
     * Uploads the vehicle's image
     *
     * @param string $vin Vehicle identification number
     * @param string $path Image's path.
     * @param string $mimeType Image's MIME Type.
     * @return bool
     */
    public function updateVehicleImage($vin, $path, $mimeType) {
        if ($this->isAdmin()) {
            $vehicle = $this->vehicleRepository->findById($vin);
            $image = new Image(null, $path, $mimeType);
            /**
             * 1. Store temp the old vehicle image key
             * 2. Remove it from the vehicle table
             * 3. Remove it from the image table
             * 4. Insert the new image in the vehicle
             * 5. Save the vehicle
             */
            if ($vehicle->getImage() !== null) {
                $oldVehicleImage = $vehicle->getImage();
                $vehicle->setImage(null);
                $this->vehicleRepository->save($vehicle);
                $this->imageRepository->deleteById($oldVehicleImage);
            }

            $image = $this->imageRepository->save($image);
            $vehicle->setImage($image);
            $this->vehicleRepository->save($vehicle);
            return true;
        }
        return false;
    }

}
