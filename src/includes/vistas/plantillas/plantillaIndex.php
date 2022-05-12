<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title><?= $tituloPagina ?></title>
	<link rel="stylesheet" type="text/css" href="src/estilo.css" />
</head>

<body>
	<div id="contenedor">
	<?php
		require('src/includes/vistas/comun/cabeceraIndex.php');
		require('src/includes/vistas/comun/sidebarIzqIndex.php');
	?>
		<main>
			<article>
			<?= $contenidoPrincipal ?>
			</article>
		</main>
	<?php
		require('src/includes/vistas/comun/sidebarDerIndex.php');
		require('src/includes/vistas/comun/pieIndex.php');
	?>
	</div>
</body>
</html>
