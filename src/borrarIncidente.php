<?php

require_once __DIR__.'/includes/config.php';

require_once __DIR__.'/includes/DamageService.php';

$idDamage = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$damageService = new DamageService($GLOBALS['db_damage_repository']);
$damageService->deleteDamage($idDamage);

echo '<meta http-equiv="refresh" content="1; url=incidente.php">';