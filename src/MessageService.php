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
    private $MessageRepository;

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
    public function __construct(MysqlMessageRepository $MessageRepository, Repository $imageRepository) {
        $this->MessageRepository = $MessageRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Persists a new Message into the system if the Message is not register before.
     * 
     * @param string $id Unique message identifier. Valid message's ID
     * @param string $author message's unique author. Valid author's name
     * @param string $message message's text.
     * @param string $image user's image.
     * @param string $date date and time. Valid date and time.
     * @param string $idParentMessage previous message's ID.
     * @return Message|null Returns null when there is an already existing Message with the same $m_id
     */
    public function createMessage($m_id, $author, $message, $date, $image, $idParentMessage) {
        $referenceMessage = $this->MessageRepository->findById($m_id);
        if ($referenceMessage === null) {
            $message = new Message($m_id, $author, $message, $date, $image, $idParentMessage);
            return $this->MessageRepository->save($message);
        }
        return null;
    }

    /**
     * Deletes a Message from the system given the m_id.
     * 
     * @param string $m_id Message's identification number.
     * @return bool
     */
    public function deleteMessage($m_id) {
        return $this->MessageRepository->deleteById($m_id);
    }

    /**
     * Returns all the Messages in the system.
     * 
     * @return Message[] Returns the Messages from the database.
     */
    public function readAllMessages(){
        return $this->MessageRepository->findAll();
    }
}