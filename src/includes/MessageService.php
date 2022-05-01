<?php
//La fecha la pasamos por parámetro o la metemos aqui??
require RAIZ_APP.'/MysqlMessageRepository.php';

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
     * @param string $txt message's txt.
     * @param string $sendTime date and time. Valid date and time.
     * @param string $idParentMessage previous message's ID.
     * @return Message|null Returns null when there is an already existing Message with the same $m_id
     */
    public function createMessage($id, $author, $txt, $sendTime, $idParentMessage) {
        $referenceMessage = $this->messageRepository->findById($id);
        if ($referenceMessage === null) {
            $message = new Message($id, $author, $txt, $sendTime, $idParentMessage);
            return $this->messageRepository->save($message);
        }
        return null;
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
}