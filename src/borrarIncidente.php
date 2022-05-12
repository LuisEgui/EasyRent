<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\service\DamageService;

$idDamage = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$damageService = DamageService::getInstance();

$damage = $damageService->readDamageById($idDamage);

$damageService->deleteDamageById($idDamage);

echo '<meta http-equiv="refresh" content="1; url=incidentesAdmin.php">';