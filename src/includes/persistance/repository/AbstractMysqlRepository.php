<?php

namespace easyrent\includes\persistance\repository;

abstract class AbstractMysqlRepository implements Repository {

    protected $db;

    public function __construct(MysqlConnector $connector) {
        $this->db = $connector;
    }

    public abstract function count() : int;

    public abstract function findById($id);

    public abstract function findAll() : array;

    public abstract function deleteById($id) : bool;

    public abstract function delete($entity) : bool;

    public abstract function save($entity);

}