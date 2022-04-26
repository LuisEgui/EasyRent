<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/MessageService.php';

$tituloPagina = 'Foro';

$contenidoPrincipal = '<h1>Mensajes del foro</h1>';
$MessageForm = new MessageService();
$contenidoPrincipal .= $MessageForm->readAllMessages();
if (isLogged()) {
	$contenidoPrincipal .= <<<EOS
		<h1>Nuevo Mensaje</h1>
	EOS;
}

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';