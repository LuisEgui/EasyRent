<?php

// Inicio del procesamiento
session_start();

// Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['email']);
unset($_SESSION['esAdmin']);

session_destroy();

echo '<h2>Successfully logout!</h2>';
echo '<p>Retornando a la página principal...</p>';
echo '<meta http-equiv="refresh" content="3;url=index.php">';
