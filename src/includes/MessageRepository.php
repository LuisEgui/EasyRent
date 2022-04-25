<?php

require_once RAIZ_APP.'/Repository.php';

/**
 * A specific repository for Users
 */
interface MessageRepository extends Repository {
    /**
     * Returns a message entity from the repository given its author.
     * @param string $author Message's author.
     * @return Message or null
     */
    public function findByAuthor($author);
}