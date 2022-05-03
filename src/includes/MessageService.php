<?php
//La fecha la pasamos por parámetro o la metemos aqui??
require RAIZ_APP.'/MysqlMessageRepository.php';
require_once RAIZ_APP.'/Message.php';

/**
 * Message Service class.
 * 
 * It manages the logic of the Message's actions. 
 */
class MessageService {

    /**
     * @var MysqlMessageRepository Message repository
     */
    private $messageRepository;

    /**
     * @var Repository Author's Image repository
     */
    private $imageRepository;

    /**
     * Creates a MessageService
     * 
     * @param MysqlMessageRepository $MessageRepository Instance of an MysqlMessageRepository
     * @param Repository $imageRepository Instance of an MysqlImageRepository
     * @return void
     */
    public function __construct(MysqlMessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Persists a new Message into the system if the Message is not register before.
     * 
     * @param string $id Unique message identifier. Valid message's ID
     * @param string $author message's unique author. Valid author's name
     * @param string $message message's text.
     * @param string $sendTime date and time. Valid date and time.
     * @param string $idParentMessage previous message's ID.
     * @return Message|null Returns null when there is an already existing Message with the same $m_id
     */
    public function createMessage($txt, $author, $idParentMessage) {
        $message = new Message(null, $author, $txt, date('Y-m-d H:i:s'), $idParentMessage);
        return $this->messageRepository->save($message);
    }

    /**
     * Deletes a Message from the system given the m_id.
     * 
     * @param string $m_id Message's identification number.
     * @return bool
     */
    public function deleteMessage($id) {
        return $this->messageRepository->deleteById($id);
    }

    /**
     * Returns all the Messages in the system.
     * 
     * @return Message[] Returns the Messages from the database.
     */
    public function readAllMessages(){
        return $this->messageRepository->findAll();
    }

    /**
     * Returns the Message with the specified id in the system.
     * 
     * @return Message Returns the Message from the database.
     */
    public function readMessageById($id){
        return $this->messageRepository->findById($id);
    }

    /**
     * Updates the Message with the specified id from the system.
     * 
     * @return Bool false if the message was modified correctly in the database.
     */
    public function updateMessage($newText, $idMessage){
        $presentMessage = $this->readMessageById($idMessage);
        $referenceMessage = $this->readMessageById($newText);
        if ($referenceMessage === null) {
            // And save the new one
            $presentMessage->setTxt($newText);
            $this->messageRepository->modify($presentMessage, $newText);
            $this->messageRepository->save($presentMessage);
            return true;
        }
        return false;
    }
}
