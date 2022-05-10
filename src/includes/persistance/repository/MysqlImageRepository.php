<?php

require_once RAIZ_APP.'/MysqlConnector.php';
require_once RAIZ_APP.'/Repository.php';
require_once RAIZ_APP.'/AbstractMysqlRepository.php';
require_once RAIZ_APP.'/Image.php';

class MysqlImageRepository extends AbstractMysqlRepository implements Repository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }
    
    public function count() {
        $sql = 'select count(img_id) as num_images from Image';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_images);
        $stmt->fetch();
        $stmt->close();
        return $num_images;
    }

    public function findById($id) {
        $image = null;

        if(!isset($id))
            return null;

        $sql = sprintf("select img_id, path, mimeType from Image where img_id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $image = new Image($obj->img_id, $obj->path, $obj->mimeType);
        }

        $result->close();

        return $image;
    }

    public function findAll() {
        $images[] = array();

        $sql = sprintf("select img_id, path, mimeType from Image");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            foreach ($row as $image)
                $images[] = $image;
        }

        return $images;
    }

    public function deleteById($id) {
        // Check if the image already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from Image where img_id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();
            
            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            
            return $result;
        }

        return false;
    }

    public function delete($image) {
        // Check entity type and we check first if the image already exists
        $importedImage = $this->findById($image->getId());
        if ($image instanceof Image && ($importedImage !== null))
            return $this->deleteById($importedImage->getId());
        return false;
    }

    public function save($image) {
        // Check entity type
        if ($image instanceof Image) {
            // If the image already exists, we do an update.
            $importedImage = $this->findById($image->getId());
            if ($importedImage !== null) {
                $sql = sprintf("update Image set path = '%s', mimeType = '%s' where img_id = %d",
                                $this->db->getConnection()->real_escape_string($image->getPath()),
                                $this->db->getConnection()->real_escape_string($image->getMimeType()),
                                $image->getId());
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $image;
                else 
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                
                return null;
            // If the image is not in the database, we insert it.
            } else {
                $sql = sprintf("insert into Image (path, mimeType) values ('%s', '%s')",
                                $this->db->getConnection()->real_escape_string($image->getPath()),
                                $this->db->getConnection()->real_escape_string($image->getMimeType()));
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if($result) {
                    // We get the asssociated id to this new user
                    $image->setId($this->db->getConnection()->insert_id);
                    return $image;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                
                return null;
            }
        }
    }

}
