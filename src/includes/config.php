<?php

/**
 * Config parameters used to generate URLs and routings for files in the app
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/sw-practices');
define('RUTA_USER_IMAGES', implode(DIRECTORY_SEPARATOR, [__DIR__.'\img', 'usr']));
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
require_once RAIZ_APP.'/MysqlConnector.php';
require_once RAIZ_APP.'/UserService.php';

session_start();

$db = MysqlConnector::getInstance();
$GLOBALS['db_connector'] = $db;
$userRepository = new MysqlUserRepository($db);
$imageRepository = new MysqlImageRepository($db);
$GLOBALS['db_user_repository'] = $userRepository;
$GLOBALS['db_image_repository'] = $imageRepository;
