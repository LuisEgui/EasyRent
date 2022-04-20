<?php

require RAIZ_APP.'/MysqlUserRepository.php';
require RAIZ_APP.'/MysqlImageRepository.php';

/**
 * User Service class.
 * 
 * It manages the logic of the user's actions. 
 */
class UserService {

    /**
     * @var UserRepository User repository
     */
    private $userRepository;

    /**
     * @var Repository Image repository
     */
    private $imageRepository;

    /**
     * Creates an UserService
     * 
     * @param UserRepository $userRepository Instance of an UserRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository, Repository $imageRepository) {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Logs in an user into the system.
     * 
     * @param string $email User's email.
     * @param string $password User's password, not hashed.
     * @return bool Returns true if the email and password corresponds to a valid user.
     * Returns false otherwise.
     */
    public function login($email, $password) {
        $user = $this->userRepository->findByEmail($email);
        return ($user && password_verify($password, $user->getPassword()));
    }

    /**
     * Returns the user from the system given an user's email.
     * 
     * @param string $email User's email.
     * @return User|null Returns the user from the database.
     */
    public function readUserByEmail($email) {
        $user = $this->userRepository->findByEmail($email);
        return $user;
    }

    /**
     * Creates a password hash.
     * This algorithm is using BCrypt with 12 rounds by default.
     * @link https://www.php.net/manual/en/function.password-hash
     * @param string $password The user's password.
     * @return string Returns the hashed password.
     */
    private static function hashPassword($password) {
        $options = [
            'cost' => 12
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Persists a new user into the system if the user is not register before.
     * 
     * @param string $email User's email. Valid user's email.
     * @param string $password User's password. No requirements on this string.
     * @param string $role User's role. Valid roles are: 'particular', 'enterprise' and 'admin'.
     * @return User|null Returns null when there is an already existing user with the same $email
     */
    public function createUser($email, $password, $role) {
        $referenceUser = $this->userRepository->findByEmail($email);
        if ($referenceUser === null) {
            $user = new User(null, $email, self::hashPassword($password), $role, null);
            return $this->userRepository->save($user);
        }
        return null;
    }

    /**
     * Checks if there's a logged user into the system, at the moment of the
     * call to this function. 
     * @return bool
     */
    private function isLogged() {
        return isset($_SESSION['email']) && isset($_SESSION['login']);
    }

    /**
     * Changes the user's email given a new email.
     * 
     * @param string $newEmail User's new email.
     * @return bool True if the user is already logged in and the $newEmail
     * is not registered before. False otherwise.
     */
    public function updateUserEmail($newEmail) {
        // If its logged in and the new email is not used by any other user
        if ($this->isLogged()) {
            $presentUser = $this->readUserByEmail($_SESSION['email']);
            $referenceUser = $this->readUserByEmail($newEmail);
            if ($referenceUser === null) {
                // We remove the old user email by deleting the user object
                $this->userRepository->delete($presentUser);
                // And save the new one
                $presentUser->setEmail($newEmail);
                $this->userRepository->save($presentUser);
                // Set the session email to the new email
                $_SESSION['email'] = $presentUser->getEmail();
                return true;
            }
            return false;
        }
        return false;
    }
    
    /**
     * Updates the user's password.
     * 
     * @param string $newPassword User's new password.
     * @return bool True if the user is already logged in. False otherwise.
     */
    public function updateUserPassword($newPassword) {
        if (self::isLogged()) {
            $user = $this->readUserByEmail($_SESSION['email']);
            $user->setPassword(self::hashPassword($newPassword));
            $this->userRepository->save($user);
            return true;
        }
        return false;
    }

    /**
     * Checks if the given role is valid to change.
     * 
     * @param string $role Desired role.
     * @return bool True if the $role is in the array: ('particular', enterprise').
     * False otherwise.
     */
    private function validRole($role) {
        $validRoles = array('particular', 'enterprise');
        return in_array($role, $validRoles);
    }

    /**
     * Updates the user's role.
     * 
     * @param string $role User's new role.
     * @return bool True if the user is already logged in and the $role is valid.
     * Returns false otherwise.
     */
    public function updateUserRole($role) {
        if (self::isLogged()) {
            $user = $this->readUserByEmail($_SESSION['email']);
            if (self::validRole($role) && $user->getRole() !== $role) {
                $user->setRole($role);
                $this->userRepository->save($user);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Uploads the user's profile image.
     * 
     * @param string $path Image's path.
     * @param string $mimeType Image's MIME Type.
     * @return bool
     */
    public function uploadUserImage($path, $mimeType) {
        if (self::isLogged()) {
            $user = $this->readUserByEmail($_SESSION['email']);
            $image = new Image(null, $path, $mimeType);
            /**
             * 1. Store temp the old user image key
             * 2. Remove it from the user table
             * 3. Remove it from the image table
             * 4. Insert the new image in the user
             * 5. Save the user
             */
            if ($user->getImage() !== null) {
                $oldUserImage = $user->getImage();
                $user->setImage(null);
                $this->userRepository->save($user);
                $this->imageRepository->deleteById($oldUserImage);
            }

            $image = $this->imageRepository->save($image);
            $user->setImage($image->getId());
            $this->userRepository->save($user);
            return true;
        }
        return false;
    }

    /**
     * Gets the user's profile image 
     * @return Image|null
     */
    public function getUserImage() {
        if (self::isLogged()) {
            $user = $this->readUserByEmail($_SESSION['email']);
            $image = $this->imageRepository->findById($user->getImage());
            return $image;
        }
        return null;
    }

    /**
     * Deletes the user's account
     * @return bool
     */
    public function deleteUserAccount() {
        if (self::isLogged()) {
            $user = $this->readUserByEmail($_SESSION['email']);
            $this->imageRepository->deleteById($user->getImage());
            $this->userRepository->delete($user);
            unset($_SESSION['login']);
            unset($_SESSION['email']);
            unset($_SESSION['esAdmin']);
            return true;
        }
        return false;
    }

}