<?php

namespace easyrent\includes\persistance\entity;

/**
 * Class for Image entity.
 */
class Image {

    /**
     * @var string Unique image identifier
     */
    private $img_id;

    /**
     * @var string Image relative path
     */
    private $path;

    /**
     * @var string Image MIME Type. Posible values: 'image/jpg' or 'image/png'
     */
    private $mimeType;

    /**
     * Creates an Image
     *
     * @param string $id Unique image identifier
     * @param string $path Image relative path
     * @param string mimeType Image MIME Type.
     * @return void
     */
    public function __construct($id = null, $path, $mimeType) {
        $this->img_id = $id;
        $this->path = $path;
        $this->mimeType = $mimeType;
    }

    /**
     * Returns image's id
     * @return string img_id
     */
    public function getId() {
        return $this->img_id;
    }

    /**
     * Returns image's relative path
     * @return string path
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Returns image's mime type
     * @return string mime type
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Sets image's id
     * @param string id
     * @return void
     */
    public function setId($id) {
        $this->img_id = $id;
    }

    /**
     * Sets image's path
     * @param string path
     * @return void
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * Sets image's mime type
     * @param string mimeType
     * @return void
     */
    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }

}
