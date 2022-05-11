<?php

namespace easyrent\includes\service;

use easyrent\includes\persistance\entity\Message;
use easyrent\includes\persistance\repository\MysqlMessageRepository;

/**
 * Message Service class.
 *
 * It manages the logic of the Message's actions.
 */
class MessageService
{

    /**
     * @var MysqlMessageRepository Message repository
     */
    private $messageRepository;

    /**
     * Creates a MessageService
     *
     * @param MysqlMessageRepository $messageRepository Instance of an MysqlMessageRepository
     * @return void
     */
    public function __construct(MysqlMessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Persists a new Message into the system if the Message is not register before.
     *
     * @param string $author message's unique author. Valid author's name
     * @param string $txt message's text.
     * @param string $idParentMessage previous message's ID.
     * @return Message|null Returns null when there is an already existing Message with the same $m_id
     */
    public function createMessage($txt, $author, $idParentMessage)
    {
        $message = new Message(null, $author, $txt, date('Y-m-d H:i:s'), $idParentMessage);
        return $this->messageRepository->save($message);
    }

    /**
     * Deletes a Message from the system given the m_id.
     *
     * @param string $id Message's identification number.
     * @return bool
     */
    public function deleteMessage($id)
    {
        return $this->messageRepository->deleteById($id);
    }

    /**
     * Returns all the Messages in the system.
     *
     * @return Message[] Returns the Messages from the database.
     */
    public function readAllMessages()
    {
        return $this->messageRepository->findAll();
    }

    /**
     * Returns the Message with the specified id in the system.
     *
     * @param string $id Message's identification number.
     * @return Message Returns the Message from the database.
     */
    public function readMessageById($id)
    {
        return $this->messageRepository->findById($id);
    }

    /**
     * Updates the Message with the specified id from the system.
     *
     * @param string $newText New message's text.
     * @param string $idMessage Message's identification number.
     * @return Bool false if the message was modified correctly in the database.
     */
    public function updateMessage($newText, $idMessage)
    {
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
