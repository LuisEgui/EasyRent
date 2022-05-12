<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Damage;

class MysqlDamageRepository extends AbstractMysqlRepository implements DamageRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }

    public function count() : int
    {
        $sql = 'select count(d_id) as num_damages from Damage';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_damages);
        $stmt->fetch();
        $stmt->close();
        return $num_damages;
    }

    public function findById($id) : ?Damage
    {
        $damage = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select * from Damage where d_id = %d", $id);
        $result = $this->db->query($sql);
        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $damage = new Damage($obj->d_id, $obj->vehicle, $obj->user, $obj->title, $obj->description, $obj->evidenceDamage, $obj->area, $obj->type, $obj->isRepaired, $obj->fecha);
        }

        $result->close();

        return $damage;
    }

    public function findAll() : array
    {
        $damages = [];

        $sql = sprintf("select * from Damage");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $damage = new Damage($row['d_id'], $row['vehicle'], $row['user'], $row['title'], $row['description'], $row['evidenceDamage'], $row['area'], $row['type'], $row['isRepaired'], $row['fecha']);
            $damages[] = $damage;
        }

        return $damages;
    }

    public function findAllId()
    {
        $damagesID = [];

        $sql = sprintf("select d_id from Damage");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $id = $row['d_id'];
            $damagesID[] = $id;
        }

        return $damagesID;
    }

    public function findByVehicle($vin) : array
    {
        $damages = [];

        if(!isset($vin))
            return $damages;

        $sql = sprintf("select * from Damage where vehicle = '%d'",
                        $vin);
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $damage = new Damage($row['d_id'], $row['vehicle'], $row['user'], $row['title'], $row['description'], $row['evidenceDamage'], $row['area'], $row['type'], $row['isRepaired'], $row['fecha']);
            $damages[] = $damage;
        }

        return $damages;
    }

    public function deleteById($d_id) : bool
    {
        // Check if the damage already exists
        if ($this->findById($d_id) !== null) {
            $sql = sprintf("delete from Damage where d_id = %d", $d_id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($damage) : bool
    {
        // Check entity type and we check first if the user already exists
        $importedDamage = $this->findById($damage->getId());
        if ($damage instanceof Damage && ($importedDamage !== null))
            return $this->deleteById($importedDamage->getId());
        return false;
    }

    public function save($damage) {
        // Check entity type
        if ($damage instanceof Damage) {
            /**
             * If the damage already exists, we do an update.
             * We retrieve the damage's id from the database.
             */
            $importedDamage = $this->findById($damage->getId());
            if ($importedDamage !== null) {
                $damage->setId($importedDamage->getId());
                if ($damage->getEvidenceDamage() !== null) {
                $sql = sprintf("update Damage set vehicle = '%d', user = '%d', title = '%d', description  = '%s', evidenceDamage ='%d', area ='%d', type ='%d', isRepaired ='%d'",
                        $damage->getVehicle(),
                        $damage->getUser(),
                        $this->db->getConnection()->real_escape_string($damage->getTitle()),
                        $this->db->getConnection()->real_escape_string($damage->getDescription()),
                        $damage->getEvidenceDamage(),
                        $this->db->getConnection()->real_escape_string($damage->getArea()),
                        $this->db->getConnection()->real_escape_string($damage->getType()),
                        $damage->getIsRepaired(),
                        $damage->getId()
                       );
                } else {
                    $sql = sprintf("update Damage set vehicle = '%d', user = '%d', title = '%d', description  = '%s', evidenceDamage = NULL, area ='%d', type ='%d', isRepaired ='%d'",
                    $damage->getVehicle(),
                    $damage->getUser(),
                    $this->db->getConnection()->real_escape_string($damage->getTitle()),
                    $this->db->getConnection()->real_escape_string($damage->getDescription()),
                    $this->db->getConnection()->real_escape_string($damage->getArea()),
                    $this->db->getConnection()->real_escape_string($damage->getType()),
                    $damage->getIsRepaired(),
                    $damage->getId()
                   );
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $damage;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                // If the reserve is not in the database, we insert it.
            } else {
                if ($damage->getEvidenceDamage() !== null) {
                    $sql = sprintf("insert into Damage (d_id, vehicle, user, title, description, evidenceDamage, area, type, isRepaired) values ('%d', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s')",
                        $damage->getId(),
                        $damage->getVehicle(),
                        $this->db->getConnection()->real_escape_string($damage->getUser()),
                        $this->db->getConnection()->real_escape_string($damage->getTitle()),
                        $this->db->getConnection()->real_escape_string($damage->getDescription()),
                        $damage->getEvidenceDamage(),
                        $this->db->getConnection()->real_escape_string($damage->getArea()),
                        $this->db->getConnection()->real_escape_string($damage->getType()),
                        $this->db->getConnection()->real_escape_string($damage->getIsRepaired())
                    );
                } else {
                    $sql = sprintf("insert into Damage (d_id, vehicle, user, title, description, area, type, isRepaired) values ('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s')",
                        $damage->getId(),
                        $damage->getVehicle(),
                        $damage->getUser(),
                        $this->db->getConnection()->real_escape_string($damage->getTitle()),
                        $this->db->getConnection()->real_escape_string($damage->getDescription()),
                        $this->db->getConnection()->real_escape_string($damage->getArea()),
                        $this->db->getConnection()->real_escape_string($damage->getType()),
                        $damage->getIsRepaired()
                    );
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {
                    // We get the asssociated id to this new reserve
                    $damage->setId($this->db->getConnection()->insert_id);
                    return $damage;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            }
        }
        return null;
    }

}
