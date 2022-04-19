<?php

/**
 * Config parameters used to generate URLs and routings for files in the app
 */
define('APP_ROOT', __DIR__);
define('APP_ROUTE', '/testing');
define('RUTA_USER_IMAGES', implode(DIRECTORY_SEPARATOR, [__DIR__.'\img', 'usr']));

/**
 * UTF-8 support configuration, location (language and country) and time-zone
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

/**
 * Initialize the database connection and session_start()
 */
require_once __DIR__.'/MysqlConnector.php';
require_once __DIR__.'/MysqlReserveRepository.php';

session_start();

$db = MysqlConnector::getInstance();
$GLOBALS['db_connector'] = $db;
$reserveRepository = new MysqlReserveRepository($db);
$GLOBALS['db_reserve_repository'] = $reserveRepository;