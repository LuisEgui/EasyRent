<?php
    use easyrent\includes\service\AdvertisementService;

    $advertisementService = new AdvertisementService($GLOBALS['db_advertisement_repository'], $GLOBALS['db_image_repository']);
    $b = $advertisementService->getBannerForDisplay();

    if ($b) {
        // Image relative path: <u_id> - <image-path>
        $imgPath = "{$b->getId()}-{$b->getPath()}";
        $banner = <<<EOS
            <div>
               <img src="includes/img/ads/$imgPath" width="800" height="100" alt="Banner"/>
            </div>
            EOS;
    }
    else $banner = 'Espacio publicitario';
?>
<aside id="sidebarIzq">
    <?= $banner ?>
</aside>
