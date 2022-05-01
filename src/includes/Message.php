<?php

/**
 * Class for message entity.
 */
class Message {

    /**
     * @var string Unique message identifier
     */
    private $id;

    /**
     * @var string Message's unique author's identifier
     */
    private $author;

    /**
     * @var string Message's text
     */
    private $message;

    /**
     * @var string Message's send time.
     */
    private $sendTime;

    /**
     * @var string Previous message's ID
     */
    private $idParentMessage;

    /**
     * Creates an Message
     * 
     * @param string $id Unique message identifier
     * @param string $author message's unique author
     * @param string $message message's text
     * @param string $sendTime message's send time
     * @param string $idParentMessage previous message's ID
     * @return Message
     */
    public function __construct($id = null, $author, $message, $sendTime, $idParentMessage) {
        $this->id = $id;
        $this->author = $author;
        $this->message = $message;
        $this->sendTime = $sendTime;
        $this->idParentMessage = $idParentMessage;
    }

    /**
     * Returns message's id
     * @return string id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns message's author
     * @return string author
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Returns message's message 
     * @return string message
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Returns message's date
     * @return string date
     */
    public function getSendTime() {
        return $this->sendTime;
    }

    /**
     * Returns message's idParentMessage
     * @return string idParentMessage
     */
    public function getidParentMessage() {
        return $this->idParentMessage;
    }

    /**
     * Sets message's id
     * @param string id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Sets message's author
     * @param string author
     * @return void
     */
    public function setAuthor($author) {
        $this->autor = $author;
    }

    /**
     * Sets message's message 
     * @param string message
     * @return void
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * Sets message's date
     * @param string date
     * @return void
     */
    public function setSendTime($sendTime) {
        $this->sendTime = $sendTime;
    }

    /**
     * Sets message's idParentMessage
     * @param string idParentMessage
     * @return void
     */
    public function setidParentMessage($idParentMessage) {
        $this->idParentMessage = $idParentMessage;
    }

}
