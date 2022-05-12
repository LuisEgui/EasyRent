<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

use easyrent\includes\forms\FormularioRegistroMensaje;
use easyrent\includes\forms\FormularioResponderMensaje;
use easyrent\includes\service\MessageService;
use easyrent\includes\service\UserService;

$tituloPagina = 'Foro';

$contenidoPrincipal = '<h1 class="adminClass">Mensajes del foro</h1>';
$messageService = new MessageService($GLOBALS['db_message_repository']);
$messages = $messageService->readAllMessages();
$userService = new UserService($GLOBALS['db_user_repository'], $GLOBALS['db_image_repository']);


for ($i = 0; $i < count($messages); $i++) {

    if($messages[$i]->getIdParentMessage() == null){
        $contenidoPrincipal .= <<<EOS
		<div class="adminClass">
		<h2>Mensaje:
		EOS;
        $contenidoPrincipal .= <<<EOS
		</h2>
		<p class="adminClass">Autor:
		EOS;
        $idAuthor = $messages[$i]->getAuthor();
        $userAuthor = $userService->readUserById($idAuthor);
        $contenidoPrincipal .= $userAuthor->getEmail();
        $contenidoPrincipal .= <<<EOS
		</p>
		<p class="adminClass">Texto:
		EOS;
        $contenidoPrincipal .= $messages[$i]->getTxt();
        $contenidoPrincipal .= <<<EOS
		</p>
		<p class="adminClass">Fecha:
		EOS;
        $contenidoPrincipal .= $messages[$i]->getSendTime();
        $contenidoPrincipal .= <<<EOS
		</p>
		EOS;
        if ($userService->isLogged() && $userAuthor->getEmail() == $_SESSION['email']){
            $contenidoPrincipal .= <<<EOS
				<a  class="adminClass" href="borrarMensaje.php?id=
			EOS;
            $contenidoPrincipal .= $messages[$i]->getId();
            $contenidoPrincipal .= <<<EOS
				">Borrar</a>
			EOS;
            $contenidoPrincipal .= <<<EOS
				<a  class="adminClass" href="editarMensaje.php?id=
			EOS;
            $contenidoPrincipal .= $messages[$i]->getId();
            $contenidoPrincipal .= <<<EOS
				">Editar</a>
			EOS;
        }
        for ($j = 0; $j < count($messages); $j++) {
            if($messages[$j]->getIdParentMessage() == $messages[$i]->getId()){
                $contenidoPrincipal .= <<<EOS
				<div class="adminClass">
				<h2 class="adminClass">Respuesta a:
				EOS;
                $contenidoPrincipal .= $userAuthor->getEmail();
                $contenidoPrincipal .= <<<EOS
				</h2>
				<p class="adminClass">Autor:
				EOS;
                $idAuthor1 = $messages[$j]->getAuthor();
                $userAuthor1 = $userService->readUserById($idAuthor1);
                $contenidoPrincipal .= $userAuthor1->getEmail();
                $contenidoPrincipal .= <<<EOS
				</p>
				<p class="adminClass">Texto:
				EOS;
                $contenidoPrincipal .= $messages[$j]->getTxt();
                $contenidoPrincipal .= <<<EOS
				</p>
				<p class="adminClass">Fecha:
				EOS;
                $contenidoPrincipal .= $messages[$j]->getSendTime();
                $contenidoPrincipal .= <<<EOS
				</p>
				</div>
				EOS;
                if ($userService->isLogged() && $userAuthor1->getEmail() == $_SESSION['email']){
                    $contenidoPrincipal .= <<<EOS
						<a  class="adminClass" href="borrarMensaje.php?id=
					EOS;
                    $contenidoPrincipal .= $messages[$j]->getId();
                    $contenidoPrincipal .= <<<EOS
						">Borrar</a>
					EOS;
                    $contenidoPrincipal .= <<<EOS
						<a  class="adminClass" href="editarMensaje.php?id=
					EOS;
                    $contenidoPrincipal .= $messages[$j]->getId();
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
			<h1 class="adminClass">Nueva respuesta</h1>
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
	<h1 class="adminClass">Nuevo mensaje</h1>
	$htmlFormRegMessage
	EOS;

} else {
    $contenidoPrincipal .= <<<EOS
			<p class="adminClass">Inicie sesión para participar en el foro.</p>
			EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
