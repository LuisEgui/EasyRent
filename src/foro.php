<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Message.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/MessageService.php';
require_once __DIR__.'/includes/FormularioRegistroMensaje.php';
require_once __DIR__.'/includes/FormularioResponderMensaje.php';
require_once __DIR__.'/includes/FormularioEliminarMensaje.php';
require_once __DIR__.'/includes/FormularioActualizarMensaje.php';

$tituloPagina = 'Foro';

$contenidoPrincipal = '<h1>Mensajes del foro</h1>';
$messageService = new MessageService($GLOBALS['db_message_repository']);
$messages = $messageService->readAllMessages();
$userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);

$contenidoPrincipal .= <<<EOS
<h1>Lista de mensajes</h1>
EOS;
$numMessagesShown = 0;
for ($i = 0; $i < count($messages); $i++) {

	if($messages[$i]->getIdParentMessage() == null){
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
		$idAuthor = $messages[$i]->getAuthor();
		$userAuthor = $userService->readUserById($idAuthor);
		$contenidoPrincipal .= $userAuthor->getEmail();
		$contenidoPrincipal .= <<<EOS
			</p>
			<p>
			Texto: 
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
	
		if ($userService->isLogged()) {
			$formres = new FormularioResponderMensaje($messages[$i]->getId());
			$htmlFormResMessage = $formres->gestiona();
			$contenidoPrincipal .= <<<EOS
			$htmlFormResMessage
			EOS;
			if($userService->readUserByEmail($_SESSION['email'])->getId() == $messages[$i]->getAuthor()){
				$formdel = new FormularioEliminarMensaje($messages[$i]->getId());
				$htmlFormDelMessage = $formdel->gestiona();
	
				//PARA EDITAR MENSAJE
				$formact = new FormularioActualizarMensaje($messages[$i]->getId());
				$htmlFormActMessage = $formact->gestiona();
				$contenidoPrincipal .= <<<EOS
				$htmlFormDelMessage
				$htmlFormActMessage
				EOS;
				
			} 
		}
		$numMessagesShown++;
	}

	for($j = $i + 1; $j < count($messages); $j++){

		if($messages[$j]->getIdParentMessage() == $messages[$i]->getId() && $numMessagesShown <= $j){
			$contenidoPrincipal .= <<<EOS
			<div class="v">
				<h2>Mensaje 
			EOS;
			$contenidoPrincipal .= $j + 1;
			$contenidoPrincipal .= <<<EOS
				</h2>
				<p>
				Autor: 
			EOS;
			$idAuthor = $messages[$j]->getAuthor();
			$userAuthor = $userService->readUserById($idAuthor);
			$contenidoPrincipal .= $userAuthor->getEmail();
			$contenidoPrincipal .= <<<EOS
				</p>
				<p>
				Texto: 
			EOS;
			$contenidoPrincipal .= $messages[$j]->getTxt();
			$contenidoPrincipal .= <<<EOS
				</p>
				<p>
				Fecha: 
			EOS;
			$contenidoPrincipal .= $messages[$j]->getSendTime();
			$contenidoPrincipal .= <<<EOS
				</p> 
			EOS;
		
			if ($userService->isLogged()) {
				$formres = new FormularioResponderMensaje($messages[$j]->getId());
				$htmlFormResMessage = $formres->gestiona();
				$contenidoPrincipal .= <<<EOS
				$htmlFormResMessage
				EOS;
				if($userService->readUserByEmail($_SESSION['email'])->getId() == $messages[$j]->getAuthor()){
					$formdel = new FormularioEliminarMensaje($messages[$j]->getId());
					$htmlFormDelMessage = $formdel->gestiona();
		
					//PARA EDITAR MENSAJE
					$formact = new FormularioActualizarMensaje($messages[$j]->getId());
					$htmlFormActMessage = $formact->gestiona();
					$contenidoPrincipal .= <<<EOS
					$htmlFormDelMessage
					$htmlFormActMessage
					EOS;
					
				} 
			}	
			$numMessagesShown++;
		}
	}
}

if ($userService->isLogged()) {

	$form = new FormularioRegistroMensaje();
	$htmlFormRegMessage = $form->gestiona();

	$tituloPagina = 'Publicación de mensaje al foro';

	$contenidoPrincipal .= <<<EOS
	<h1>Nuevo mensaje</h1>
	$htmlFormRegMessage
	EOS;

}


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
