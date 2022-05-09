<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Message.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/MessageService.php';
require_once __DIR__.'/includes/FormularioRegistroMensaje.php';
require_once __DIR__.'/includes/FormularioResponderMensaje.php';

$tituloPagina = 'Foro';

$contenidoPrincipal = '<h1>Mensajes del foro</h1>';
$messageService = new MessageService($GLOBALS['db_message_repository']);
$messages = $messageService->readAllMessages();
$userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);


for ($i = 0; $i < count($messages); $i++) {

	if($messages[$i]->getIdParentMessage() == null){
		$contenidoPrincipal .= <<<EOS
		<div class="v">
		<h2>Mensaje: 
		EOS;
		$contenidoPrincipal .= <<<EOS
		</h2>
		<p>Autor: 
		EOS;
		$idAuthor = $messages[$i]->getAuthor();
		$userAuthor = $userService->readUserById($idAuthor);
		$contenidoPrincipal .= $userAuthor->getEmail();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Texto: 
		EOS;
		$contenidoPrincipal .= $messages[$i]->getTxt();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Fecha: 
		EOS;
		$contenidoPrincipal .= $messages[$i]->getSendTime();
		$contenidoPrincipal .= <<<EOS
		</p> 
		EOS;
		if ($userService->isLogged() && $userAuthor->getEmail() == $_SESSION['email']){
			$contenidoPrincipal .= <<<EOS
			<a href="borrarMensaje.php?id=
			EOS;
			$contenidoPrincipal .= $messages[$i]->getId();
			$contenidoPrincipal .= <<<EOS
			">Borrar</a> 
			EOS;
			$contenidoPrincipal .= <<<EOS
			<a href="editarMensaje.php?id= 
			EOS;
			$contenidoPrincipal .= $messages[$i]->getId();
			$contenidoPrincipal .= <<<EOS
			 ">Editar</a> 
			EOS;
		}
		for ($j = 0; $j < count($messages); $j++) {
			if($messages[$j]->getIdParentMessage() == $messages[$i]->getId()){
				$contenidoPrincipal .= <<<EOS
				<div class="v">
				<h2>Respuesta a: 
				EOS;
				$contenidoPrincipal .= $userAuthor->getEmail();
				$contenidoPrincipal .= <<<EOS
				</h2>
				<p>Autor: 
				EOS;
				$idAuthor1 = $messages[$j]->getAuthor();
				$userAuthor1 = $userService->readUserById($idAuthor1);
				$contenidoPrincipal .= $userAuthor1->getEmail();
				$contenidoPrincipal .= <<<EOS
				</p>
				<p>Texto: 
				EOS;
				$contenidoPrincipal .= $messages[$j]->getTxt();
				$contenidoPrincipal .= <<<EOS
				</p>
				<p>Fecha: 
				EOS;
				$contenidoPrincipal .= $messages[$j]->getSendTime();
				$contenidoPrincipal .= <<<EOS
				</p> 
				</div>
				EOS;
				if ($userService->isLogged() && $userAuthor1->getEmail() == $_SESSION['email']){
					$contenidoPrincipal .= <<<EOS
					<a href="borrarMensaje.php?id=
					EOS;
					$contenidoPrincipal .= $messages[$i]->getId();
					$contenidoPrincipal .= <<<EOS
					">Borrar</a> 
					EOS;
					$contenidoPrincipal .= <<<EOS
					<a href="editarMensaje.php?id= 
					EOS;
					$contenidoPrincipal .= $messages[$i]->getId();
					$contenidoPrincipal .= <<<EOS
					 ">Editar</a> 
					EOS;
				}
			}
		}
		if($userService->isLogged()){
			$form = new FormularioResponderMensaje($messages[$i]->getId());
			$htmlFormRegAnswer = $form->gestiona();
	
			$contenidoPrincipal .= <<<EOS
			<h1>Nueva respuesta</h1>
			$htmlFormRegAnswer
			EOS;
	
			
		}
		$contenidoPrincipal .= <<<EOS
			</div>
		EOS;
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

} else {
	$contenidoPrincipal .= <<<EOS
			<p>Inicie sesión para participar en el foro.</p>
			EOS;
}


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
