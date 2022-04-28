<?php

namespace easyrent\includes\persistance\repository;

abstract class AbstractMysqlRepository implements Repository {

    protected $db;

    public function __construct(MysqlConnector $connector) {
        $this->db = $connector;
    }

    public abstract function count();

    public abstract function findById($id);

    public abstract function findAll();

    public abstract function deleteById($id);

    public abstract function delete($entity);

    public abstract function save($entity);

}
