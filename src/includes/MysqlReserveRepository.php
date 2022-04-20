<?php

require_once __DIR__.'/MysqlConnector.php';
require_once __DIR__.'/ReserveRepository.php';
require_once __DIR__.'/Reserve.php';
require_once __DIR__.'/AbstractMysqlRepository.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/User.php';

class MysqlReserveRepository extends AbstractMysqlRepository implements ReserveRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }
    
    public function count() {
        $sql = 'select count(id) as num_reserves from Reserve';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_reserves);
        $stmt->fetch();
        $stmt->close();
        return $num_reserves;
    }

    public function findById($id) {
        $reserve = null;

        if (!isset($id))
            return null;

        $sql = sprintf("select id, vehicle, user, state, pickupLocation, returnLocation, " .
            "pickupTime, returnTime, price from Reserve where id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $reserve = new Reserve($obj->id, $obj->vehicle, $obj->user, $obj->role, 
                            $obj->state, $obj->pickupLocation, $obj->returnLocation, 
                            $obj->pickupTime , $obj->returnTime, $obj->price);
        }

        $result->close();

        return $reserve;
    }

    public function findByVehicleAndUserAndPickUptime($vehicle, $user, $pickUpTime) {
        $reservas = [];

        $sql = sprintf("select id, vehicle, user, state, pickupLocation, returnLocation, pickupTime, returnTime, price from Reserve where user = %d", $user->getId());
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $reserva = new Reserve(null, $row['vehicle'], $row['user'], $row['state'], $row['pickupLocation'], $row['returnLocation'], $row['pickupTime'], $row['returnTime'], $row['price']);
            $reservas[] = $reserva;
        }
        
        return $reservas;
    }

    public function findAllByUser($user) {
        $reservas[] = array();

        $sql = sprintf("select id, vehicle, user, state, pickupLocation, returnLocation, pickupTime, returnTime, price from Reserve where user = '%d'",
                        $user->getId());
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $reserve)
                $reservas[] = $reserve;
        }

        return $reservas;
    }

    public function findAll() {
        $reservas[] = array();

        $sql = sprintf("id, vehicle, user, state, pickupLocation, returnLocation, pickupTime, returnTime, price from Reserve");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $reserve)
                $reservas[] = $reserve;
        }

        return $reservas;
    }

    public function deleteById($id) {
        // Check if the reserve already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from Reserve where id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            
            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            
            return $result;
        }

        return false;
    }

    public function delete($reserve) {
        // Check entity type and we check first if the user already exists
        $importedReserve = $this->findById($reserve->getId());
        if ($reserve instanceof Reserve && ($importedReserve !== null))
            return $this->deleteById($importedReserve->getId());
        return false;
    }

    public function save($reserve) {
        // Check entity type
        if ($reserve instanceof Reserve) {
            /**
             * If the reserve already exists, we do an update.
             * We retrieve the reserve's id from the database.
             */
            $importedReserve = $this->findById($reserve->getId());
            if ($importedReserve !== null) {
                $reserve->setId($importedReserve->getId());
                $sql = sprintf("update Reserve set vehicle = '%d', state = '%s', pickupLocation = '%s', " . 
                        "returnLocation = '%s', pickupTime = '%s', returnTime = '%s', price = '%f' where id = %d",
                        $this->db->getConnection()->real_escape_string($reserve->getVehicle()),
                        $this->db->getConnection()->real_escape_string($reserve->getState()),
                        $this->db->getConnection()->real_escape_string($reserve->getPickUpLocation()),
                        $this->db->getConnection()->real_escape_string($reserve->getReturnLocation()),
                        $this->db->getConnection()->real_escape_string($reserve->getPickUpTime()),
                        $this->db->getConnection()->real_escape_string($reserve->getReturnTime()),
                        $reserve->getPrice(), $reserve->getId());
                
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $reserve;
                else 
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                // If the reserve is not in the database, we insert it.
            } else {
                $sql = sprintf("insert into Reserve (vehicle, user, pickupLocation, pickupTime, returnTime, price) values ('%s', '%s', '%s', '%s', '%f'",
                        $this->db->getConnection()->real_escape_string($reserve->getVehicle()),
                        $this->db->getConnection()->real_escape_string($reserve->getState()),
                        $this->db->getConnection()->real_escape_string($reserve->getPickUpLocation()),
                        $this->db->getConnection()->real_escape_string($reserve->getReturnLocation()),
                        $this->db->getConnection()->real_escape_string($reserve->getPickUpTime()),
                        $this->db->getConnection()->real_escape_string($reserve->getReturnTime()),
                        $reserve->getPrice());
                
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {
                    // We get the asssociated id to this new reserve
                    $reserve->setId($this->db->getConnection()->insert_id);
                    return $reserve;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            }
        }
        return null;
    }

}
