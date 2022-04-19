<?php

require_once __DIR__.'/MysqlConnector.php';
require_once __DIR__.'/ReserveRepository.php';
require_once __DIR__.'/Reserva.php';
require_once __DIR__.'/AbstractMysqlRepository.php';
require_once __DIR__.'/config.php';

class MysqlReserveRepository extends AbstractMysqlRepository implements ReserveRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }
    
    public function count() {
        $sql = 'select count(u_id) as num_users from User';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_users);
        $stmt->fetch();
        $stmt->close();
        return $num_users;
    }

    private function getReservas()
    { 
        $reservas = [];
    
        $user = User::findUserByEmail($_SESSION['email']);

        $sql = sprintf("select vehicle, user, state, pickupLocation, returnLocation, pickupTime, returnTime, price from reserve where user = %d", $user->getId());
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $reserva = new Reserve($row['vehicle'], $row['user'], $row['state'], $row['pickupLocation'], $row['returnLocation'], $row['pickupTime'], $row['returnTime'], $row['price']);
            $reservas[] = $reserva;
        }
        
        return $reservas;
    }

    public function reservasPersonales() {
        return self::getReservas();
    }

    public function findById($id){}

    public function findAll(){}

    public function deleteById($id){}

    public function delete($entity){}

    public function save($entity){}

    public function findByVehicleUserPickUptime($vehicle, $user, $pickUpTime){}

}







