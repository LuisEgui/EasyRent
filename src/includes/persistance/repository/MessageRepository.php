<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Message;

/**
 * A specific repository for Users
 */
interface MessageRepository extends Repository
{
    /**
     * Returns a message entity from the repository given its author.
     * @param string $author Message's author.
     * @return array
     */
    public function findByAuthor($author) : array;
}

