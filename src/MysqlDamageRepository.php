<?php


//ESTA CLASE TIENE LAS IMPLEMENTACIONES DE "MENSAJES" HAY QUE ADAPTARLO A DAMAGE





require_once RAIZ_APP.'/MysqlConnector.php';
require_once RAIZ_APP.'/DamageRepository.php';
require_once RAIZ_APP.'/Damage.php';
require_once RAIZ_APP.'/AbstractMysqlRepository.php';

class MysqlDamageRepository extends AbstractMysqlRepository implements DamageRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }
    
    public function count() {
        $sql = 'select count(d_id) as num_damages from Damage';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_damages);
        $stmt->fetch();
        $stmt->close();
        return $num_damages;
    }

    public function findById($id) {
        $damage = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select d_id, vehicle, user, title, description, evidenceDamage from Damage where id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $damage = new Damage($obj->id, $obj->author, $obj->txt, $obj->sendTime, $obj->idParentMessage);
        }

        $result->close();

        return $message;
    }

    public function findAll() {
        $messages = [];

        $sql = sprintf("select id, author, txt, sendTime, idParentMessage from Message");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $message = new Message($row['id'], $row['author'], $row['txt'], $row['sendTime'], $row['idParentMessage']);
            $messages[] = $message;
        }

        return $messages;
    }

    public function findByAuthor($author) {
        $messages[] = array();

        $sql = sprintf("select id, author, txt, sendTime, idParentMessage from Message where author = '%d'",
                        $author);
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
        // Check if the message already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("SET FOREIGN_KEY_CHECKS=0");
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            $sql = sprintf("delete from Message where id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            $sql = sprintf("SET FOREIGN_KEY_CHECKS=1");
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
        // Check entity type and we check first if the user already exists
        $importedMessage = $this->findById($message->getId());
        if ($message instanceof Message && ($importedMessage !== null))
            return $this->deleteById($importedMessage->getId());
        return false;
    }

    public function save($message) {
        // Check entity type
        if ($message instanceof Message) {
            /**
             * If the message already exists, we do an update.
             * We retrieve the message's id from the database.
             */
            $importedMessage = $this->findById($message->getId());
            if ($importedMessage !== null) {
                $message->setId($importedMessage->getId());
                $sql = sprintf("update Message set author = '%d', txt = '%s', sendTime = '%s', idParentMessage = '%s'",
                        $this->db->getConnection()->real_escape_string($message->getAuthor()),
                        $this->db->getConnection()->real_escape_string($message->getTxt()),
                        $this->db->getConnection()->real_escape_string($message->getSendTime()),
                        $this->db->getConnection()->real_escape_string($message->getIdParentMessage()),
                        $message->getId());
                
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $message;
                else 
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                // If the reserve is not in the database, we insert it.
            } else {
                if ($message->getIdParentMessage() !== null) {
                    $sql = sprintf("insert into Message (author, txt, sendTime, idParentMessage) values ('%d', '%s', '%s', '%d')",
                        $message->getAuthor(),
                        $this->db->getConnection()->real_escape_string($message->getTxt()),
                        $this->db->getConnection()->real_escape_string($message->getSendTime()),
                        $message->getIdParentMessage());
                } else {
                    $sql = sprintf("insert into Message (author, txt, sendTime) values ('%d', '%s', '%s')",
                        $message->getAuthor(),
                        $this->db->getConnection()->real_escape_string($message->getTxt()),
                        $this->db->getConnection()->real_escape_string($message->getSendTime()));
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {
                    // We get the asssociated id to this new reserve
                    $message->setId($this->db->getConnection()->insert_id);
                    return $message;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            }
        }
        return null;
    }

}
