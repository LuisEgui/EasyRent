<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Vehicle;

class MysqlVehicleRepository extends AbstractMysqlRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }

    public function count() : int
    {
        $sql = 'select count(vin) as num_vehicles from Vehicle';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_vehicles);
        $stmt->fetch();
        $stmt->close();
        return $num_vehicles;
    }

    public function findById($vin) : ?Vehicle
    {
        $vehicle = null;

        if(!isset($vin))
            return null;

        $sql = sprintf("select vin, licensePlate, model, vehicleImg, fuelType, seatCount, state from Vehicle where vin = %d", $vin);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $vehicle = new Vehicle($obj->vin, $obj->licensePlate, $obj->model, $obj->fuelType, $obj->seatCount, $obj->state);
        }

        $result->close();

        return $vehicle;
    }

    public function findAll() : array
    {
        $vehicles = [];

        $sql = sprintf("select vin, licensePlate, model, vehicleImg, fuelType, seatCount, state from Vehicle");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $vehicle = new Vehicle($row['vin'], $row['licensePlate'], $row['model'], $row['vehicleImg'], $row['fuelType'], $row['seatCount'], $row['state']);
            $vehicles[] = $vehicle;
        }

        return $vehicles;
    }

    public function deleteById($vin) : bool
    {
        // Check if the vehicle already exists
        if ($this->findById($vin) !== null) {
            $sql = sprintf("delete from Vehicle where vin = %d", $vin);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();

            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($vehicle) : bool
    {
        // Check entity type and we check first if the user already exists
        $importedVehicle = $this->findById($vehicle->getVin());
        if ($vehicle instanceof Vehicle && ($importedVehicle !== null))
            return $this->deleteById($importedVehicle->getVin());
        return false;
    }

    public function save($vehicle)
    {
        // Check entity type
        if ($vehicle instanceof Vehicle) {
            /**
             * If the vehicle already exists, we do an update.
             */
            $importedVehicle = $this->findById($vehicle->getVin());
            if ($importedVehicle !== null) {
                if ($vehicle->getImage() !== null) {
                    $sql = sprintf("update Vehicle set licensePlate = '%s', model = '%d', vehicleImg = '%d', fuelType = '%s', seatCount = '%d', state = '%s' where vin = %s",
                        $this->db->getConnection()->real_escape_string($vehicle->getLicensePlate()),
                        $vehicle->getModel(),
                        $vehicle->getImage(),
                        $this->db->getConnection()->real_escape_string($vehicle->getFuelType()),
                        $vehicle->getSeatCount(),
                        $this->db->getConnection()->real_escape_string($vehicle->getState()),
                        $this->db->getConnection()->real_escape_string($vehicle->getVin()));
                } else {
                    $sql = sprintf("update Vehicle set licensePlate = '%s', model = '%d', fuelType = '%s', seatCount = '%d', state = '%s' where vin = %s",
                        $this->db->getConnection()->real_escape_string($vehicle->getLicensePlate()),
                        $vehicle->getModel(),
                        $this->db->getConnection()->real_escape_string($vehicle->getFuelType()),
                        $vehicle->getSeatCount(),
                        $this->db->getConnection()->real_escape_string($vehicle->getState()),
                        $this->db->getConnection()->real_escape_string($vehicle->getVin()));
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $vehicle;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            // If the vehicle is not in the database, we insert it.
            } else {
                if ($vehicle->getImage() !== null) {
                    $sql = sprintf("insert into Vehicle (vin, licensePlate, model, vehicleImg, fuelType, seatCount, state) values ('%s', '%s', '%d', '%d', '%s', '%d', '%s')",
                        $this->db->getConnection()->real_escape_string($vehicle->getVin()),
                        $this->db->getConnection()->real_escape_string($vehicle->getLicensePlate()),
                        $vehicle->getModel(),
                        $vehicle->getImage(),
                        $this->db->getConnection()->real_escape_string($vehicle->getFuelType()),
                        $vehicle->getSeatCount(),
                        $this->db->getConnection()->real_escape_string($vehicle->getState()));
                } else {
                    $sql = sprintf("insert into Vehicle (vin, licensePlate, model, fuelType, seatCount, state) values ('%s', '%s', '%d', '%s', '%d', '%s')",
                        $this->db->getConnection()->real_escape_string($vehicle->getVin()),
                        $this->db->getConnection()->real_escape_string($vehicle->getLicensePlate()),
                        $vehicle->getModel(),
                        $this->db->getConnection()->real_escape_string($vehicle->getFuelType()),
                        $vehicle->getSeatCount(),
                        $this->db->getConnection()->real_escape_string($vehicle->getState()));
                }
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if($result) {
                    return $vehicle;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            }
        }
        return null;
    }

}
