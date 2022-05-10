<?php
require RAIZ_APP.'/MysqlDamageRepository.php';
require_once RAIZ_APP.'/Damage.php';

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
     * Creates a DamageService
     * 
     * @param MysqlDamageRepository $DamageRepository Instance of an MysqlDamageRepository
     * @param Repository $DamageRepository Instance of an MysqDamageRepository
     * @return void
     */
    public function __construct(MysqlDamageRepository $damageRepository) {
        $this->damageRepository = $damageRepository;
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
    public function createDamage($vehicle, $user, $title, $description, $evidenceDamage,$area, $type, $isRepaired) {
        $damage = new Damage(null, $vehicle, $user, $title, $description, $evidenceDamage, $area, $type, $isRepaired);
        return $this->damageRepository->save($damage);
    }

    /**
     * Deletes a Damage from the system given the d_id.
     * 
     * @param string $d_id Damage's identification number.
     * @return bool
     */
    public function deleteDamage($id) {
        return $this->damageRepository->deleteById($id);
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
}
