<?php

// phpcs:ignoreFile
function mostrarSaludo() {
	if (isset($_SESSION['login']) && ($_SESSION['login']===true)) {
		return "Bienvenido, {$_SESSION['email']} <a href='logout.php'>(salir)</a>";
	} else {
		return "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}
}

function mostrarMenu() {
    $rutaApp = RUTA_APP;
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && $_SESSION['esAdmin']) {
		return "<a href='{$rutaApp}/src/index.php'>Inicio</a>
				<a href='{$rutaApp}/src/admin.php'>Administrar</a>
				<a href='{$rutaApp}/src/chat.php'>Chat gestion incidentes</a>
				<a href='{$rutaApp}/src/perfil.php'>Tu perfil</a>
				<a href='{$rutaApp}/src/foro.php'>Foro</a>
				<a href='{$rutaApp}/src/logout.php'>Cerrar sesion</a>";
	}
	else if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		return "<a href='{$rutaApp}/src/index.php'>Inicio</a>
				<a href='{$rutaApp}/src/chat.php'>Chat informar incidentes</a>
				<a href='{$rutaApp}/src/tusreservas.php'>Tus reservas</a>
				<a href='{$rutaApp}/src/incidente.php'>Generar Incidente</a>
				<a href='{$rutaApp}/src/promociones.php'>Tus promociones</a>
				<a href='{$rutaApp}/src/perfil.php'>Tu perfil</a>
				<a href='{$rutaApp}/src/foro.php'>Foro</a>
				<a href='{$rutaApp}/src/logout.php'>Cerrar sesion</a>";
	} else {
		return "<a href='{$rutaApp}/src/index.php'>Inicio</a>
				<a href='{$rutaApp}/src/registro.php'>Registrarse</a>
				<a href='{$rutaApp}/src/foro.php'>Foro</a>
				<a href='{$rutaApp}/src/Contacto.php'>Contacto</a>";
	}
}

?>
<header>

	<div class="navegador">
		<div class="logo" style="position: relative;"><img src="<?=RUTA_IMGS?>/logo_easyRent.png" width="135" height="75" alt="EasyRent Logo"/></div>

		<div class="dropdown">
		<button class="dropbtn" style="float:left">Menu</button>
		<div class="dropdown-content">
			<?= mostrarMenu() ?>
		</div>
		</div>

		<div class="saludo" ><?= mostrarSaludo(); ?></div>

	</div>

</header>
