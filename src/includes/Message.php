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
     * @var string Profile user image.
     */
    private $image;

    /**
     * @var string date and time
     */
    private $date;

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
     * @param string $image user's image
     * @param string $date date and time
     * @param string $idParentMessage previous message's ID
     * @return Message
     */
    public function __construct($id = null, $author, $message, $date, $image, $idParentMessage) {
        $this->id = $id;
        $this->author = $autor;
        $this->message = $message;
        $this->date = $date;
        $this->image = $image;
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
    public function getDate() {
        return $this->date;
    }

    /**
     * Returns user's image id
     * @return string image
     */
    public function getImage() {
        return $this->image;
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
        $this->mensaje = $message;
    }

    /**
     * Sets message's date
     * @param string date
     * @return void
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * Sets user's image id
     * @param string image
     * @return void
     */
    public function setImage($image) {
        $this->image = $image;
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