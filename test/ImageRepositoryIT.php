<?php

use easyrent\includes\persistance\entity\Image;
use easyrent\includes\persistance\repository\MysqlConnector;
use easyrent\includes\persistance\repository\MysqlImageRepository;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class ImageRepositoryIT extends TestCase {

    public $repository;
    public $db;

    protected function setUp(): void {
        $this->db = MysqlConnector::getInstance();
        $this->repository = new MysqlImageRepository($this->db);
        $this->db->beginTransaction();
    }

    protected function tearDown(): void {
        $this->db->rollback();
    }

    /**
     * @test
     * @cover MysqlImageRepository::count()
     */
    public function testCount() : void {
        $count = $this->repository->count();
        assertTrue($count == 1);
    }

    /**
     * @test
     * @covers MysqlImageRepository::findById()
     */
    public function testFindById() : void {
        $expectedId = '1';
        $actualId = $this->repository->findById(1)->getId();
        assertSame($expectedId, $actualId);
    }

    /**
     * @test
     * @covers MysqlImageRepository::findById()
     */
    public function testFindByNullId() : void {
        $image = $this->repository->findById(null);
        assertTrue($image == null);
    }

    /**
     * @test
     * @covers MysqlImageRepository::deleteById()
     */
    public function testDeleteById() : void {
        $beforeDelete = $this->repository->count();
        assertTrue($this->repository->deleteById(1));
        $afterDelete = $this->repository->count();
        assertNotSame($beforeDelete, $afterDelete);
    }

    /**
     * @test
     * @covers MysqlImageRepository::deleteById()
     */
    public function testDeleteByNullId() : void {
        $beforeDeleteNumImages = $this->repository->count();
        assertFalse($this->repository->deleteById(null));
        $afterDeleteNumImages = $this->repository->count();
        assertSame($beforeDeleteNumImages, $afterDeleteNumImages);
    }

    /**
     * @test
     * @covers MysqlImageRepository::save()
     */
    public function testUpdateImagePath() : void {
        // Check that we are updating the image's path since we're using the img_id = 1
        $updatedImage = new Image(1, 'image.png', 'png');
        // Before updating the image's path, we get the old one
        $actualImagePath = $this->repository->findById(1)->getPath();
        $this->repository->save($updatedImage);
        $updatedImagePath = $this->repository->findById(1)->getPath();
        // We achieve the new image's path
        assertNotSame($actualImagePath, $updatedImagePath);
    }

    /**
     * @test
     * @covers MysqlImageRepository::save()
     */
    public function testSaveNewImage() : void {
        $newImage = new Image(null, 'image.png', 'png');
        // Before saving the new image, we get the actual number of images
        $numImages = $this->repository->count();
        $newImage = $this->repository->save($newImage);
        // After inserting a new image, we expect that the num. of images had incremented by 1
        $expectedNumImages = $numImages + 1;
        assertNotSame($numImages, $expectedNumImages);
        // We also check that the new image has a new id
        assertTrue($newImage->getId() !== null);
    }

    /**
     * @test
     * @covers MysqlImageRepository::save()
     */
    public function testSaveNullImage() : void {
        $beforeSaveNumImages = $this->repository->count();
        $this->repository->save(null);
        $afterSaveNumImages = $this->repository->count();
        assertSame($beforeSaveNumImages, $afterSaveNumImages);
    }

}
