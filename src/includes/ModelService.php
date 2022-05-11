<?php

require RAIZ_APP.'/MysqlModelRepository.php';
require_once RAIZ_APP.'/Model.php';

/**
 * Vehicle Service class.
 *
 * It manages the logic of the vehicle's actions.
 */
class ModelService {

    /**
     * @var MysqlModelRepository Model repository
     */
    private $modelRepository;

    /**
     * @var Repository Image repository
     */
    private $imageRepository;

    /**
     * @var ModelService Single instance of ModelService class.
     */
    private static $instance;

    /**
     * Creates a ModelService
     *
     * @param MysqlModelRepository $modelRepository Instance of an MysqlModelRepository
     * @param Repository $imageRepository Instance of an MysqlImageRepository
     * @return void
     */
    private function __construct() {
        $this->modelRepository = $GLOBALS['db_model_repository'];
        $this->imageRepository = $GLOBALS['db_image_repository'];
    }

    /**
     * Controls the Singleton Pattern of ModelService class. If the instance of ModelService class exists, returns it. If not, returns it after creting it.
     *
     * @return ModelService $instance Single instance of ModelService
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Persists a new model into the system if the model is not register before.
     *
     * @param string $brand Model's brand. Valid model's brand.
     * @param string $model Model's model. Valid model's model.
     * @param string $submodel Model's submodel. Valid model's submodel.
     * @param string $gearbox Model's gearbox. Valid types are: 'manual', 'automatic', 'semi-automatic', 'duplex'.
     * @param string $category Model's category. Valid types are: 'coupe', 'pickup', 'roadster', 'sedan', 'small-car', 'suv', 'van'.
     * @param string $fuelType Model's fuel type. Valid types are: 'diesel', 'ehybrid', 'hybrid', 'petrol', 'plugInHybrid'.
     * @param string $seatCount Model's seat count. Valid model's seat count.
     * @return Model|null Returns null when there is an already existing model with the same $submodel
     */
    public function createModel($brand, $model, $submodel, $gearbox, $category, $fuelType, $seatCount, $image) {
        $referenceModel = $this->modelRepository->findBySubmodel($submodel);
        if ($referenceModel === null) {
            $model = new Model(null, $brand, $model, $submodel, $gearbox, $category, $fuelType, $seatCount, $image);
            return $this->modelRepository->save($model);
        }
        return null;
    }

    /**
     * Deletes a model from the system given the Id.
     *
     * @param string $m_id Model's identification.
     * @return bool
     */
    public function deleteModelById($m_id) {
        $model = $this->modelRepository->findById($m_id);
        $oldUserImageId = $model->getImage();
        $oldUserImage = $this->imageRepository->findById($oldUserImageId);
        $oldUserImageFile = "{$oldUserImage->getId()}-{$oldUserImage->getPath()}";
        $oldUserImagePath =
            implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)).'\img\model', $oldUserImageFile]);
        unlink($oldUserImagePath);
        return ($this->modelRepository->deleteById($m_id) && $this->imageRepository->deleteById($model->getImage()));
    }

    /**
     * Returns all the models in the system.
     *
     * @return Model[] Returns the models from the database.
     */
    public function readAllModels(){
        $models = $this->modelRepository->findAll();
        return $models;
    }

    /**
     * Returns the model by its id
     *
     * @return Model|null Returns null when there is not an existing model with the same $m_id
     */
    public function readModelById($m_id){
        return $this->modelRepository->findById($m_id);
    }

    /**
     * Uploads the user's profile image.
     *
     * @param string $path Image's path.
     * @param string $mimeType Image's MIME Type.
     * @return bool
     */
    public function saveImage($image){
        return $this->imageRepository->save($image);
    }
}
