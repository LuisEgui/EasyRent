<?php

namespace easyrent\includes\persistance\repository;

/**
 * General repository interface.
 *
 * Defines general repository' actions.
 */
interface Repository {

    /**
     * Counts the number of rows from a repository.
     * @return int Number of rows
     */
    public function count();

    /**
     * Deletes a given entity from the repository.
     * @param mixed $entity Entity to be deleted
     * @return bool
     */
    public function delete($entity);

    /**
     * Deletes a given entity by its id
     * @param string $id Entity's id
     * @return bool
     */
    public function deleteById($id);

    /**
     * Reads all entities from the reposity.
     * @return array of entities or null.
     */
    public function findAll();

    /**
     * Returns a entity object given its id
     * @param string $id
     * @return mixed|null Entity or null
     */
    public function findById($id);

    /**
     * Saves into the repository a given entity.
     * @param mixed $entity Entity to be saved.
     * @return mixed|null Saved entity or null in case of error.
     */
    public function save($entity);

}
