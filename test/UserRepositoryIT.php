<?php

use easyrent\includes\persistance\entity\User;
use easyrent\includes\persistance\repository\MysqlConnector;
use easyrent\includes\persistance\repository\MysqlUserRepository;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class UserRepositoryIT extends TestCase {

    public $repository;
    public $db;

    protected function setUp(): void {
        $this->db = MysqlConnector::getInstance();
        $this->repository = new MysqlUserRepository($this->db);
        $this->db->beginTransaction();
    }

    protected function tearDown(): void {
        $this->db->rollback();
    }

    /**
     * @test
     * @covers MysqlUserRepository::count()
     */
    public function testCount() : void {
        $count = $this->repository->count();
        assertTrue($count == 1);
    }

    /**
     * @test
     * @covers MysqlUserRepository::findById()
     */
    public function testFindById() : void {
        $expectedId = '1';
        $actualId = $this->repository->findById(1)->getId();
        assertSame($expectedId, $actualId);
    }

    /**
     * @test
     * @covers MysqlUserRepository::findById()
     */
    public function testFindByNullId() : void {
        $user = $this->repository->findById(null);
        assertTrue($user == null);
    }

    /**
     * @test
     * @covers MysqlUserRepository::findByEmail()
     */
    public function testFindByEmail() : void {
        $expectedEmail = 'luis@easyrent.com';
        $email = $this->repository->findByEmail('luis@easyrent.com')->getEmail();
        assertSame($expectedEmail, $email);
    }

    /**
     * @test
     * @covers MysqlUserRepository::findByEmail()
     */
    public function testFindByNullEmail() : void {
        $user = $this->repository->findByEmail(null);
        assertTrue($user == null);
    }

    /**
     * @test
     * @covers MysqlUserRepository::findAll()
     */
    public function testFindAll() : void {
        $users = array();
        $users = $this->repository->findAll();

        assertTrue($users != null);
        assertTrue(sizeof($users) != 0);
    }

    /**
     * @test
     * @covers MysqlUserRepository::deleteById()
     */
    public function testDeleteById() : void {
        $beforeDelete = $this->repository->count();
        assertTrue($this->repository->deleteById(1));
        $afterDelete = $this->repository->count();
        assertNotSame($beforeDelete, $afterDelete);
    }

    /**
     * @test
     * @covers MysqlUserRepository::deleteById()
     */
    public function testDeleteByNullId() : void {
        $beforeDeleteNumUsers = $this->repository->count();
        assertFalse($this->repository->deleteById(null));
        $afterDeleteNumUsers = $this->repository->count();
        assertSame($beforeDeleteNumUsers, $afterDeleteNumUsers);
    }

    /**
     * @test
     * @covers MysqlUserRepository::save()
     */
    public function testSaveNewUserIdAndEmail() : void {
        $newUser = new User(null, 'elon@easyrent.com',
        '$2a$12$JZERzQcCfpMaNOXVYtqy2.yTvyvIRlwd/TnygtYHaj20gBDaLW8OK',
        'admin', null);
        // Before saving the new user, we get the actual number of users
        $numUsers = $this->repository->count();
        assertTrue($this->repository->save($newUser) !== null);
        // After inserting a new user, we expect that the num. of users had incremented by 1
        $expectedNumUsers = $numUsers + 1;
        assertNotSame($numUsers, $expectedNumUsers);
    }

    /**
     * @test
     * @covers MysqlUserRepository::save()
     */
    public function testSaveNullUser() : void {
        $beforeSaveNumUsers = $this->repository->count();
        $this->repository->save(null);
        $afterSaveNumUsers = $this->repository->count();
        assertSame($beforeSaveNumUsers, $afterSaveNumUsers);
    }

}
