<?php

/**
 * Class for user entity.
 */
class User {

    /**
     * @var string Unique user identifier
     */
    private $id;

    /**
     * @var string Unique user email
     */
    private $email;

    /**
     * @var string Encrypted user password.
     */
    private $password;

    /**
     * @var string User role
     */
    private $role;

    /**
     * @var string Profile user image.
     */
    private $image;

    /**
     * Creates an User
     * 
     * @param string $id Unique user identifier
     * @param string $email Unique user email
     * @param string $password Encrypted user password.
     * @param string $role User role. Possible values: 'admin', 'particular',
     * 'enterprise'.
     * @return User
     */
    public function __construct($id = null, $email, $password, $role, $image) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->image = $image;
    }

    /**
     * Returns user's id
     * @return string id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns user's email
     * @return string email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Returns user's password 
     * @return string password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Returns user's role
     * @return string role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Returns user's image id
     * @return string image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets user's id
     * @param string $id User id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Sets user's email
     * @param string $email User email
     * @return void
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Sets user's password
     * @param string $password
     * @return void
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Sets user's role
     * @param string $role
     * @return void
     */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * Sets user's profile image.
     * @param string $image Image ID
     * @return void
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * Check if an user has a determined role
     * 
     * @param string $role Check if the user has this role.
     * @return bool
     */
    public function hasRole($role) {
        return ($this->role === $role) ? true : false;
    }

}