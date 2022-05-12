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
		require('src/includes/vistas/comun/sidebarIzq.php');
	?>
		<main>
			<article>
			<?= $contenidoPrincipal ?>
			</article>
		</main>
	<?php
		require('src/includes/vistas/comun/sidebarDer.php');
		require('src/includes/vistas/comun/pie.php');
	?>
	</div>
</body>
</html>
