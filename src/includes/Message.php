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
     * @var string Único autor del mensaje
     */
    private $autor;

    /**
     * @var string Texto del mensaje
     */
    private $mensaje;

    /**
     * @var string Profile user image.
     */
    private $image;

    /**
     * @var string fecha y hora
     */
    private $fecha;

    /**
     * @var string idmensajeanterior
     */
    private $idMensajePadre;

    /**
     * Creates an Message
     * 
     * @param string $id Unique message identifier
     * @param string $autor Único autor del mensaje
     * @param string $mensaje Texto del mensaje
     * @param string $image Profile user image.
     * @param string $fecha fecha y hora
     * @param string $idMensajePadre idmensajeanterior
     * @return Message
     */
    public function __construct($id = null, $autor, $mensaje, $fecha, $image, $idMensajePadre) {
        $this->id = $id;
        $this->autor = $autor;
        $this->mensaje = $mensaje;
        $this->fecha = $fecha;
        $this->image = $image;
        $this->idMensajePadre = $idMensajePadre;
    }

    /**
     * Returns message's id
     * @return string id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns message's autor
     * @return string autor
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Returns message's mensaje 
     * @return string mensaje
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Returns message's fecha
     * @return string fecha
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Returns user's image id
     * @return string image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Returns message's idMensajePadre
     * @return string idMensajePadre
     */
    public function getIdMensajePadre() {
        return $this->idMensajePadre;
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
     * Sets message's autor
     * @param string autor
     * @return void
     */
    public function setAutor($autor) {
        $this->autor = $autor;
    }

    /**
     * Sets message's mensaje 
     * @param string mensaje
     * @return void
     */
    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    /**
     * Sets message's fecha
     * @param string fecha
     * @return void
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
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
     * Sets message's idMensajePadre
     * @param string idMensajePadre
     * @return void
     */
    public function setIdMensajePadre($idMensajePadre) {
        $this->idMensajePadre = $idMensajePadre;
    }

}