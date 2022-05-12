<?php

/**
 * Config parameters used to generate URLs and routings for files in the app
 */

define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/sw-practices');
define('RUTA_USER_IMAGES', implode(DIRECTORY_SEPARATOR, [__DIR__.'\\src\\includes\\img', 'usr']));
define('RUTA_VEHICLE_IMAGES', implode(DIRECTORY_SEPARATOR, [__DIR__.'\\src\\includes\\img', 'vehicle']));
define('RUTA_IMGS', RUTA_APP.'/doc/web/images');

/**
 * UTF-8 support configuration, location (language and country) and time-zone
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

/**
 * Initialize the database connection and session_start()
 */

use easyrent\includes\persistance\repository\MysqlConnector;
use easyrent\includes\persistance\repository\MysqlImageRepository;
use easyrent\includes\persistance\repository\MysqlMessageRepository;
use easyrent\includes\persistance\repository\MysqlUserRepository;
use easyrent\includes\persistance\repository\MysqlVehicleRepository;
use easyrent\includes\persistance\repository\MysqlModelRepository;
use easyrent\includes\persistance\repository\MysqlReserveRepository;
use easyrent\includes\persistance\repository\MysqlAdvertisementRepository;
use easyrent\includes\persistance\repository\MysqlPriorityRepository;

session_start();

$db = MysqlConnector::getInstance();
$GLOBALS['db_connector'] = $db;
$reserveRepository = new MysqlReserveRepository($db);
$GLOBALS['db_reserve_repository'] = $reserveRepository;
$userRepository = new MysqlUserRepository($db);
$imageRepository = new MysqlImageRepository($db);
$vehicleRepository = new MysqlVehicleRepository($db);
$modelRepository = new MysqlModelRepository($db);
$messageRepository = new MysqlMessageRepository($db);
$priorityRepository = new MysqlPriorityRepository($db);
$advertisementRepository = new MysqlAdvertisementRepository($db);
$GLOBALS['db_user_repository'] = $userRepository;
$GLOBALS['db_image_repository'] = $imageRepository;
$GLOBALS['db_vehicle_repository'] = $vehicleRepository;
$GLOBALS['db_model_repository'] = $modelRepository;
$GLOBALS['db_message_repository'] = $messageRepository;
$GLOBALS['db_advertisement_repository'] = $advertisementRepository;
$GLOBALS['db_priority_repository'] = $priorityRepository;
