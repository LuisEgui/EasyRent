<?php
//EN EL SAVE COMO SE GUARDA LA IMAGEN, QUE TIPO DE DATO ES??
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

    public function findAllByAuthor($author) {
        $messages[] = array();

        $sql = sprintf("select m_id, author, message, date, image, idParentMessage from Message where author = '%d'",
                        $author->getId());
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
            $sql = sprintf("delete from Message where id = %d", $id);
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
                $sql = sprintf("update Message set author = '%d', message = '%s', image = '%s', " . 
                        "date = '%s', idParentMessage = '%s'",
                        $this->db->getConnection()->real_escape_string($message->getAuthor()),
                        $this->db->getConnection()->real_escape_string($message->getMessage()),
                        $this->db->getConnection()->real_escape_string($message->getImage()),
                        $this->db->getConnection()->real_escape_string($message->getDate()),
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
                $sql = sprintf("insert into Message (author, message, date, image, idParentMessage) values ('%s', '%s', '%s', '%s', '%s'",
                        $this->db->getConnection()->real_escape_string($message->getAuthor()),
                        $this->db->getConnection()->real_escape_string($message->getMessage()),
                        $this->db->getConnection()->real_escape_string($message->getImage()),
                        $this->db->getConnection()->real_escape_string($message->getDate()),
                        $this->db->getConnection()->real_escape_string($message->getIdParentMessage());
                
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