<?php
//HAY QUE HACER EL DELETE Y EL SAVE AUNN
require_once RAIZ_APP.'/MysqlConnector.php';
require_once RAIZ_APP.'/MessageRepository.php';
require_once RAIZ_APP.'/Message.php';
require_once RAIZ_APP.'/AbstractMysqlRepository.php';

class MysqlMessageRepository extends AbstractMysqlRepository implements MessageRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }
    
    public function count() {
        $sql = 'select count(m_id) as num_messages from Message';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_messages);
        $stmt->fetch();
        $stmt->close();
        return $num_messages;
    }

    public function findById($id) {
        $message = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select m_id, author, message, date, image, idParentMessage from Message where m_id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $message = new Message($obj->m_id, $obj->author, $obj->message, $obj->date, $obj->image, $obj->idParentMessage);
        }

        $result->close();

        return $message;
    }

    public function findByAuthor($author) {
        $message = null;

        if(!isset($author))
            return null;

            $sql = sprintf("select m_id, author, message, date, image, idParentMessage from Message where author = %d", 
                            $this->db->getConnection()->real_escape_string($author));
            $result = $this->db->query($sql);
    
            if ($result !== false && $result->num_rows > 0) {
                $obj = $result->fetch_object();
                $message = new Message($obj->m_id, $obj->author, $obj->message, $obj->date, $obj->image, $obj->idParentMessage);
            }
    
            $result->close();
    
            return $message;
    }

    public function findAll() {
        $messages[] = array();

        $sql = sprintf("select m_id, author, message, date, image, idParentMessage from Message");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $message)
                $messages[] = $message;
        }

        return $messages;
    }

    public function deleteById($id) {
        // Check if the user already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from Message where m_id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            
            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            
            return $result;
        }

        return false;
    }

    public function delete($message) {
        // Check entity type and we check first if the message already exists
        $importedMessage = $this->findByAuthor($message->getAuthor());
        if ($message instanceof Message && ($importedMessage !== null))
            return $this->deleteById($importedMessage->getId());
        return false;
    }

    public function save($message) {
        // Check entity type
        if ($message instanceof Message) {
            /**
             * If the user already exists, we do an update.
             * We retrieve the user's id from the database.
             */
            $importedMessage = $this->findByEmail($user->getEmail());
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