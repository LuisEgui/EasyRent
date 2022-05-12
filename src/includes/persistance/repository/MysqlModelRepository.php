<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Model;

class MysqlModelRepository extends AbstractMysqlRepository {

    public function __construct(MysqlConnector $connector) {
        parent::__construct($connector);
    }

    public function count() : int
    {
        $sql = 'select count(m_id) as num_models from Model';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_models);
        $stmt->fetch();
        $stmt->close();
        return $num_models;
    }

    public function findById($m_id) : ?Model
    {
        $model = null;

        if(!isset($m_id))
            return null;

        $sql = sprintf("select * from Model where m_id = %d", $m_id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $model = new Model($obj->m_id, $obj->brand, $obj->model, $obj->submodel, $obj->gearbox, $obj->category, $obj->fuelType, $obj->seatCount, $obj->vehicleImg, $obj->fecha);
        }

        $result->close();

        return $model;
    }

    public function findBySubmodel($submodel) : ?Model
    {
        $model = null;

        if(!isset($email))
            return null;

        $sql = sprintf("select * from Model where submodel = '%s'",
                        $this->db->getConnection()->real_escape_string($submodel));
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $model = new Model($obj->m_id, $obj->brand, $obj->model, $obj->submodel, $obj->gearbox, $obj->category, $obj->fuelType, $obj->seatCount, $obj->vehicleImg, $obj->fecha);
        }

        $result->close();

        return $model;
    }

    public function findAll() : array
    {
        $models = [];

        $sql = sprintf("select * from Model");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $model = new Model($row['m_id'], $row['brand'], $row['model'], $row['submodel'], $row['gearbox'], $row['category'], $row['fuelType'], $row['seatCount'], $row['vehicleImg'], $row['fecha']);
            $models[] = $model;
        }
        
        return $models;
    }

    public function deleteById($m_id) : bool
    {
        // Check if the model already exists
        if ($this->findById($m_id) !== null) {
            echo "$m_id";
            $sql = sprintf("delete from Model where m_id = %d", $m_id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();

            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($model) : bool
    {
        // Check entity type and we check first if the model already exists
        $importedModel = $this->findById($model->getId());
        if ($model instanceof Model && ($importedModel !== null))
            return $this->deleteById($importedModel->getId());
        return false;
    }

    public function save($model)
    {
        // Check entity type
        if ($model instanceof Model) {
            /**
             * If the model already exists, we do an update.
             */
            $importedModel = $this->findBySubmodel($model->getSubmodel());
            if ($importedModel !== null) {
                $sql = sprintf("update Model set brand = '%s', model = '%s', submodel = '%s', gearbox = '%s', category = '%s', fuelType = '%s', seatCount = '%d', vehicleImg = '%d' where m_id = %d",
                    $this->db->getConnection()->real_escape_string($model->getBrand()),
                    $this->db->getConnection()->real_escape_string($model->getModel()),
                    $this->db->getConnection()->real_escape_string($model->getSubmodel()),
                    $this->db->getConnection()->real_escape_string($model->getGearbox()),
                    $this->db->getConnection()->real_escape_string($model->getCategory()),
                    $this->db->getConnection()->real_escape_string($model->getFuelType()),
                    $model->getSeatCount(),
                    $model->getImage(),
                    $model->getId());
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $model;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            // If the model is not in the database, we insert it.
            } else {
                $sql = sprintf("insert into Model (brand, model, submodel, gearbox, category, fuelType, seatCount, vehicleImg) values ('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')",
                $this->db->getConnection()->real_escape_string($model->getBrand()),
                $this->db->getConnection()->real_escape_string($model->getModel()),
                $this->db->getConnection()->real_escape_string($model->getSubmodel()),
                $this->db->getConnection()->real_escape_string($model->getGearbox()),
                $this->db->getConnection()->real_escape_string($model->getCategory()),
                $this->db->getConnection()->real_escape_string($model->getFuelType()),
                $model->getSeatCount(),
                $model->getImage());
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if($result) {
                    return $model;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
            }
        }
        return null;
    }

}