<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistroMensaje.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$form = new FormularioResponderMensaje($idMensaje);
$htmlFormRegMessage = $form->gestiona();
$contenidoPrincipal .= <<<EOS
$htmlFormRegMessage
EOS;
