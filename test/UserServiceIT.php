<?php

namespace test;

use easyrent\includes\persistance\repository\MysqlConnector;
use easyrent\includes\persistance\repository\MysqlImageRepository;
use easyrent\includes\persistance\repository\MysqlUserRepository;
use easyrent\includes\service\UserService;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertNotEquals;

class UserServiceIT extends TestCase {

    public $userRepository;
    public $imageRepository;
    public $userService;
    public $db;

    protected function setUp(): void {
        $this->db = MysqlConnector::getInstance();
        $this->userRepository = new MysqlUserRepository($this->db);
        $this->imageRepository = new MysqlImageRepository($this->db);
        $this->userService = new UserService($this->userRepository, $this->imageRepository);
        $this->db->beginTransaction();
    }

    protected function tearDown(): void {
        $this->db->rollback();
        if (isset($_SESSION)) {
            unset($_SESSION['login']);
            unset($_SESSION['email']);
        }
    }

    /**
     * @test
     * @cover UserService::login()
     *
     * We check false conditions:
     * -> Null $email
     * -> Null password
     * -> SQL Injection
     */
    public function testLogin() : void {
        assertTrue($this->userService->login("luis@easyrent.com", "1234"));
        assertFalse($this->userService->login(null, "1234"));
        assertFalse($this->userService->login("luis@easyrent.com", null));
        assertFalse($this->userService->login(null, null));
        assertFalse($this->userService->login('" or ""="', '" or ""="'));
    }

    /**
     * @test
     * @cover UserService::readUserByEmail()
     */
    public function testReadUserByEmail() : void {
        $user = $this->userService->readUserByEmail("luis@easyrent.com");
        assertTrue($user !== null);
        assertSame('luis@easyrent.com', $user->getEmail());
    }

    /**
     * @test
     * @cover UserService::createUser()
     */
    public function testCreateUser() : void {
        $user = $this->userService->createUser("elon@easyrent.com", "1234", "admin");
        assertSame("elon@easyrent.com", $user->getEmail());
        assertSame('admin', $user->getRole());
        // The password must be hashed when the user is created, so we check:
        assertNotSame('1234', $user->getPassword());
    }

    /**
     * @test
     * @cover UserService::createUser()
     */
    public function testCreateAlreadyExistingUser() : void {
        $user = $this->userService->createUser("luis@easyrent.com", "1234", "admin");
        assertTrue($user === null);
    }

    /**
     * @test
     * @cover UserService::updateUserEmail()
     */
    public function testUpdateUserEmail() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        assertTrue($this->userService->updateUserEmail("elon@easyrent.com"));
    }

    /**
     * @test
     * @cover UserService::updateUserEmail()
     */
    public function testUpdateSameUserEmail() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        assertFalse($this->userService->updateUserEmail("luis@easyrent.com"));
    }

    /**
     * @test
     * @cover UserService::updateUserEmail()
     */
    public function testUpdateUserEmailWhenNotLoggedIn() : void {
        assertFalse($this->userService->updateUserEmail("elon@easyrent.com"));
    }

    /**
     * @test
     * @cover UserService::updateUserPassword()
     */
    public function testUpdateUserPassword() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        $beforeUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertTrue($this->userService->updateUserPassword("4321"));
        $afterUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertNotEquals($beforeUpdateUser->getPassword(), $afterUpdateUser->getPassword());
    }

    /**
     * @test
     * @cover UserService::updateUserPassword()
     */
    public function testUpdateUserPasswordWhenNotLoggedIn() : void {
        assertFalse($this->userService->updateUserPassword("4321"));
    }

    /**
     * @test
     * @cover UserService::updateUserRole()
     */
    public function testUpdateUserRole() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        $beforeUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertTrue($this->userService->updateUserRole("enterprise"));
        $afterUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertNotSame($beforeUpdateUser, $afterUpdateUser);
    }

    /**
     * @test
     * @cover UserService::updateUserRole()
     */
    public function testUpdateUserRoleWhenNotLoggedIn() : void {
        assertFalse($this->userService->updateUserRole("enterprise"));
    }

    /**
     * @test
     * @cover UserService::updateUserRole()
     */
    public function testUpdateInvalidUserRole() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        assertFalse($this->userService->updateUserRole("notValidRole"));
    }

    /**
     * @test
     * @cover UserService::uploadUserImage()
     */
    public function testUploadUserImage() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        $beforeUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertTrue($this->userService->uploadUserImage("user-image.png", "png"));
        $afterUpdateUser = $this->userService->readUserByEmail("luis@easyrent.com");
        assertNotSame($beforeUpdateUser, $afterUpdateUser);
        assertTrue($beforeUpdateUser->getImage() === null);
        assertTrue($afterUpdateUser->getImage() !== null);
    }

    /**
     * @test
     * @cover UserService::getUserImage()
     */
    public function testGetUserImage() : void {
        // We manually set $_SESSION['email'] and $_SESSION['login']
        // simulating that the user logged correctly before
        $_SESSION['email'] = "luis@easyrent.com";
        $_SESSION['login'] = true;
        // We upload an image to the user:
        $this->userService->uploadUserImage("user-image.png", "png");
        $image = $this->userService->getUserImage();
        assertTrue($image !== null);
    }

    /**
     * @test
     * @cover UserService::getUserImage()
     */
    public function testGetUserImageWhenNotLoggedIn() : void {
        assertFalse($this->userService->uploadUserImage("user-image.png", "png"));
    }

}
