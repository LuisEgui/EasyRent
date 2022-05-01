<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Message.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/MessageService.php';

$tituloPagina = 'Foro';

$contenidoPrincipal = '<h1>Mensajes del foro</h1>';
$MessageService = new MessageService($GLOBALS['db_message_repository']);
$messages = $MessageService->readAllMessages();
$usuario = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);
if ($usuario->isLogged()) {
	$contenidoPrincipal .= <<<EOS
		<h1>Nuevo Mensaje</h1>
	EOS;
	for ($i = 0; $i < count($messages); $i++) {
		$contenidoPrincipal .= <<<EOS
		<div class="v">
			<h2>Mensaje 
		EOS;
		$contenidoPrincipal .= $i + 1;
		$contenidoPrincipal .= <<<EOS
			</h2>
			<p>
			Autor: 
		EOS;
		$contenidoPrincipal .= $messages[$i]->getAuthor();
		$contenidoPrincipal .= <<<EOS
			</p>
			<p>
			Mensaje: 
		EOS;
		$contenidoPrincipal .= $messages[$i]->getTxt();
		$contenidoPrincipal .= <<<EOS
			</p>
			<p>
			Fecha: 
		EOS;
		$contenidoPrincipal .= $messages[$i]->getSendTime();
		$contenidoPrincipal .= <<<EOS
			</p> 
		EOS;
	}
}


require __DIR__.'/includes/vistas/plantillas/plantilla.php';