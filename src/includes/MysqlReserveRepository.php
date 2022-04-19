<?php

require_once __DIR__.'/MysqlConnector.php';
require_once __DIR__.'/ReserveRepository.php';
require_once __DIR__.'/Reserve.php';
require_once __DIR__.'/AbstractMysqlRepository.php';

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


    

    public function findByVehicleUserPickUptime($vehicle, $user, $pickUpTime){



        
   /* }($id) {
        $user = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select u_id, email, password, role, userImg from User where u_id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $user = new User($obj->u_id, $obj->email, $obj->password, $obj->role, $obj->userImg);
        }

        $result->close();

        return $user;
    }*/
    
}

}