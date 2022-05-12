<?php

namespace easyrent\includes\service;

use easyrent\includes\persistance\entity\Damage;

/**
 * Damage Service class.
 *
 * It manages the logic of the Damages's actions.
 */
class DamageService {

    /**
     * @var MysqlDamageRepository Damage repository
     */
    private $damageRepository;

    /**
     * @var Repository Damage's Image repository
     */
    private $imageRepository;

    /**
     * @var DamageService Single instance of DamageService class.
     */
    private static $instance;

    /**
     * Creates a DamageService
     *
     * @return void
     */
    private function __construct() {
        $this->damageRepository = $GLOBALS['db_damage_repository'];
        $this->imageRepository = $GLOBALS['db_image_repository'];
    }

    /**
     * Controls the Singleton Pattern of DamageService class. If the instance of DamageService class exists, returns it. If not, returns it after creting it.
     *
     * @return DamageService $instance Single instance of DamageService
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Persists a new Damage into the system if the Damage is not register before.
     *
     * @param string $vehicle damage's vehicle
     * @param string $user user's ID.
     * @param string $title damage's title.
     * @param string $description damage´s description.
     * @param string $evidenceDamage damage´s image.
     * @param string $area damage´s area
     * @param string $type damage´s type
     * @param string $isRepaired damage´s isRepaired
     * @return Damage|null Returns null when there is an already existing Damage with the same $d_id
     */
    public function createDamage($vehicle, $user, $title, $description, $evidenceDamage,$area, $type) {
        $damage = new Damage(null, $vehicle, $user, $title, $description, $evidenceDamage, $area, $type);
        return $this->damageRepository->save($damage);
    }

    /**
     * Deletes a Damage from the system given the d_id.
     *
     * @param string $d_id Damage's identification number.
     * @return bool
     */
    public function deleteDamageById($id) {
        $damage = $this->damageRepository->findById($id);
        $oldUserImageId = $damage->getEvidenceDamage();
        $oldUserImage = $this->imageRepository->findById($oldUserImageId);
        $oldUserImageFile = "{$oldUserImage->getId()}-{$oldUserImage->getPath()}";
        $oldUserImagePath =
            implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)).'\img\damage', $oldUserImageFile]);
        unlink($oldUserImagePath);
        return ($this->damageRepository->deleteById($id) && $this->imageRepository->deleteById($damage->getEvidenceDamage()));
    }

    /**
     * Returns all the Damage in the system.
     *
     * @return Damage[] Returns the Damage from the database.
     */
    public function readAllDamages(){
        return $this->damageRepository->findAll();
    }

    /**
     * Returns the damages related with a vehicle
     *
     * @return Damage[]|null Returns null when there is not an existing damage with the same $idVehicle associated
     */
    public function readDamagesByVehicle($idVehicle){
        return $this->damageRepository->findByVehicle($idVehicle);
    }

    /**
     * Returns all the damages id in the system.
     *
     * @return Damage[] Returns the damages id from the database.
     */
    public function readAllDamagesID(){
        return $this->damageRepository->findAllId();
    }

    /**
     * Returns the Damage with the specified id in the system.
     *
     * @return Damage Returns the Damage from the database.
     */
    public function readDamageById($id){
        return $this->damageRepository->findById($id);
    }

    /**
     * Updates the Damage with the specified id from the system.
     *
     * @return Bool false if the message was modified correctly in the database.
     */
    public function updateDamage($isRepaired, $description, $d_id){
        $presentDamage = $this->readDamageById($d_id);

        // We remove the old user email by deleting the user object
        $this->damageRepository->delete($presentDamage);
        // And save the new one
        $presentDamage->setDescription($description);
        $presentDamage->setIsRepaired($isRepaired);
        $this->damageRepository->save($presentDamage);
        return true;
    }

    /**
     * Uploads the user's profile image.
     *
     * @param string $path Image's path.
     * @param string $mimeType Image's MIME Type.
     * @return Image|null
     */
    public function saveImage($image){
        return $this->imageRepository->save($image);
    }

    public function getDamageImage($id){
        return $this->imageRepository->findById($id);
    }
}
