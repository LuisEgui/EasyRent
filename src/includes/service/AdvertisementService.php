<?php

namespace easyrent\includes\service;

use easyrent\includes\persistance\entity\Image;
use easyrent\includes\persistance\entity\Advertisement;
use easyrent\includes\persistance\repository\Repository;
use easyrent\includes\persistance\repository\MysqlAdvertisementRepository;

/**
 * User Service class.
 *
 * It manages the logic of the user's actions.
 */
class AdvertisementService
{

    /**
     * @var MysqlAdvertisementRepository Advertisement repository
     */
    private $advertisementRepository;

    /**
     * @var Repository Image repository
     */
    private $imageRepository;

    /**
     * Creates an AdvertisementService
     *
     * @param MysqlAdvertisementRepository $AdvertisementRepository Instance of an MysqlAdvertisementRepository
     * @return void
     */
    public function __construct(MysqlAdvertisementRepository $advertisementRepository, Repository $imageRepository)
    {
        $this->advertisementRepository = $advertisementRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Persists a new ad into the system if the ad is not register before.
     *
     * @param string $banner Ad image banner's id
     * @param string $releaseDate Ad's release date. Format: YYYY-MM-dd hh:mm:ss
     * @param string $endDate Ad's end date. Format: YYYY-MM-dd hh:mm:ss
     * @param string $priority Ad priority's id
     * @return Advertisement|null Returns null when there is an already existing vehicle with the same $vin
     */
    public function createAdvertisement($banner, $releaseDate, $endDate, $priority) {
        if($releaseDate > $endDate) return null;
        $ad = new Advertisement(null, $banner, $releaseDate, $endDate, $priority);
        return $this->advertisementRepository->save($ad);
    }

    /**
     * Returns all the ads in the system.
     *
     * @return Advertisement[] Returns the vehicles from the database.
     */
    public function readAllAds(){
        return $this->advertisementRepository->findAll();
    }


    public function updateAdReleaseDate($id, $newReleaseDate) {
        $ad = $this->advertisementRepository->findById($id);
        if($newReleaseDate > $ad->getEndDate()) return false;
        $ad->setReleaseDate($newReleaseDate);
        $this->advertisementRepository->save($ad);
        return true;
    }

    public function updateAdEndDate($id, $newEndDate) {
        $ad = $this->advertisementRepository->findById($id);
        if($newEndDate < $ad->getReleaseDate()) return false;
        $ad->setEndDate($newEndDate);
        $this->advertisementRepository->save($ad);
        return true;
    }

    /**
     * Uploads the ad's banner.
     *
     * @param string $path Banner's path.
     * @param string $mimeType Banner's MIME Type.
     * @return bool
     */
    public function uploadBanner($path, $mimeType, $a_id)
    {
        $ad = $this->advertisementRepository->findById($a_id);
        $image = new Image(null, $path, $mimeType);
        /**
         * 1. Store temp the old user image key
         * 2. Remove it from the user table and directory of user images
         * 3. Remove it from the image table
         * 4. Insert the new image in the user
         * 5. Save the user
         */
        if ($ad->getBanner() !== null) {
            $oldAdImageId = $ad->getBanner();
            $oldAdImage = $this->imageRepository->findById($oldAdImageId);
            $oldAdImageFile = "{$oldAdImage->getId()}-{$oldAdImage->getPath()}";
            $oldAdImagePath =
                implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)).'\img\ads', $oldAdImageFile]);
            unlink($oldAdImagePath);
            $ad->setBanner(null);
            $this->advertisementRepository->save($ad);
            $this->imageRepository->deleteById($oldAdImageId);
        }

        $image = $this->imageRepository->save($image);
        $ad->setBanner($image->getId());
        $this->advertisementRepository->save($ad);
        return true;
    }

    /**
     * Gets the ad's banner
     * @return Image|null
     */
    public function getBanner($id)
    {
        $ad = $this->advertisementRepository->findById($id);;
        $banner = $ad->getBanner();
        if (!$banner) return null;
        return $this->imageRepository->findById($banner);
    }

    /**
     * Gets the ad's banner for display
     * @return Image|null
     */
    public function getBannerForDisplay()
    {
        $ads = $this->advertisementRepository->findAll();

        $topPriority = '3';
        $id = '0';
        $today = date('Y-m-d h:i:s');

        for($i = 0; $i < count($ads); $i++) {
            if(($ads[$i]->getReleaseDate() < $today) && ($ads[$i]->getEndDate() > $today)){
                if ($topPriority > $ads[$i]->getPriority() && $ads[$i]->getBanner()) {
                    $topPriority = $ads[$i]->getPriority();
                    $id = $ads[$i]->getId();
                }
            }
        }

        if ($id === '0') return null;

        $ad = $this->advertisementRepository->findById($id);
        $banner = $ad->getBanner();
        return $this->imageRepository->findById($banner);
    }

    /**
     * Deletes the ad
     * @return bool
     */
    public function deleteAdvertisement($id)
    {
        $ad = $this->advertisementRepository->findById($id);
        $this->imageRepository->deleteById($ad->getBanner());
        $this->advertisementRepository->delete($ad);
        return true;
    }
}
