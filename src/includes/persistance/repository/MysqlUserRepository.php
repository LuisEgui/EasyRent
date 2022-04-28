<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\User;

class MysqlUserRepository extends AbstractMysqlRepository implements UserRepository {

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

    public function findById($id) {
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
    }

    public function findByEmail($email) {
        $user = null;

        if(!isset($email))
            return null;

        $sql = sprintf("select u_id, email, password, role, userImg from User where email = '%s'",
                        $this->db->getConnection()->real_escape_string($email));
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $user = new User($obj->u_id, $obj->email, $obj->password, $obj->role, $obj->userImg);
        }

        $result->close();

        return $user;
    }

    public function findAll() {
        $users[] = array();

        $sql = "select u_id, email, password, role, userImg from User";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $user)
                $users[] = $user;
        }

        return $users;
    }

    public function deleteById($id) {
        // Check if the user already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from User where u_id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();

            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($user) {
        // Check entity type and we check first if the user already exists
        $importedUser = $this->findByEmail($user->getEmail());
        if ($user instanceof User && ($importedUser !== null))
            return $this->deleteById($importedUser->getId());
        return false;
    }

    public function save($user) {
        // Check entity type
        if ($user instanceof User) {
            /**
             * If the user already exists, we do an update.
             * We retrieve the user's id from the database.
             */
            $importedUser = $this->findByEmail($user->getEmail());
            if ($importedUser !== null) {
                $user->setId($importedUser->getId());
                if ($user->getImage() !== null) {
                    $sql = sprintf("update User set email = '%s', password = '%s', role = '%s', userImg = '%d' where u_id = %d",
                        $this->db->getConnection()->real_escape_string($user->getEmail()),
                        $this->db->getConnection()->real_escape_string($user->getPassword()),
                        $this->db->getConnection()->real_escape_string($user->getRole()),
                        $this->db->getConnection()->real_escape_string($user->getImage()),
                        $user->getId());
                } else {
                    $sql = sprintf("update User set email = '%s', password = '%s', role = '%s', userImg = NULL where u_id = %d",
                        $this->db->getConnection()->real_escape_string($user->getEmail()),
                        $this->db->getConnection()->real_escape_string($user->getPassword()),
                        $this->db->getConnection()->real_escape_string($user->getRole()),
                        $user->getId());
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $user;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

                return null;
            // If the user is not in the database, we insert it.
            } else {
                if ($user->getImage() !== null) {
                    $sql = sprintf("insert into User (email, password, role, userImg) values ('%s', '%s', '%s', '%d')",
                        $this->db->getConnection()->real_escape_string($user->getEmail()),
                        $this->db->getConnection()->real_escape_string($user->getPassword()),
                        $this->db->getConnection()->real_escape_string($user->getRole()),
                        $user->getImage());
                } else {
                    $sql = sprintf("insert into User (email, password, role) values ('%s', '%s', '%s')",
                        $this->db->getConnection()->real_escape_string($user->getEmail()),
                        $this->db->getConnection()->real_escape_string($user->getPassword()),
                        $this->db->getConnection()->real_escape_string($user->getRole()));
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if($result) {
                    // We get the asssociated id to this new user
                    $user->setId($this->db->getConnection()->insert_id);
                    return $user;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

                return null;
            }
        }
        return null;
    }

}
