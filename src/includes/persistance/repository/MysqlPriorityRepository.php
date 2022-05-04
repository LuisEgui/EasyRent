<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Priority;

class MysqlPriorityRepository extends AbstractMysqlRepository implements Repository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }

    public function count() : int
    {
        $sql = 'select count(p_id) as num_priorities from Priority';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_priorities);
        $stmt->fetch();
        $stmt->close();
        return $num_priorities;
    }

    public function findById($id): ?Priority
    {
        $priority = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select p_id, level, price from Priority where p_id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $priority = new Priority($obj->p_id, $obj->level, $obj->price);
        }

        $result->close();

        return $priority;
    }

    public function findAll() : array
    {
        $priorities[] = array();

        $sql = "select p_id, level, price from Priority";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $priority)
                $priorities[] = $priority;
        }

        return $priorities;
    }

    public function deleteById($id): bool
    {
        // Check if the priority already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from Priority where p_id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();

            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($priority) : bool
    {
        // Check entity type and we check first if the priority already exists
        $importedPriority = $this->findByEmail($priority->getId());
        if ($priority instanceof Priority && ($importedPriority !== null))
            return $this->deleteById($importedPriority->getId());
        return false;
    }

    public function save($priority)
    {
        if ($priority instanceof Priority) {
            /**
             * If the priority already exists, we do an update.
             * We retrive the priority's id from the database.
             */
            $importedPriority = $this->findById($priority->getId());
            if ($importedPriority !== null) {
                $priority->setId($importedPriority->getId());
                $sql = sprintf("update Priority set level = '%s', price = '%f' where p_id = '%d'",
                $this->db->getConnection()->real_escape_string($priority->getLevel()),
                $priority->getPrice(),
                $priority->getId());

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $priority;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                return null;
                // If the priority is not in the database, we insert it.
            } else {
                $sql = sprintf("insert into Priority (level, price) values ('%s', '%s')",
                    $this->db->getConnection()->real_escape_string($priority->getLevel()),
                    $priority->getPrice());

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {
                    // We get the associated id to this priority
                    $priority->setId($this->db->getConnection()->insert_id);
                    return $priority;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

                return null;
            }
        }
        return null;
    }

}

