<?php

require_once __DIR__.'/includes/config.php';

require_once __DIR__.'/includes/MessageService.php';
require_once __DIR__.'/includes/UserService.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$messageService = new MessageService($GLOBALS['db_message_repository']);
$userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
$messageService->deleteMessage($idMensaje);

echo '<meta http-equiv="refresh" content="1; url=foro.php">';
