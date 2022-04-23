<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title><?= $tituloPagina ?></title>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>

<body>
	<div id="contenedor">
	<?php
		require('includes/vistas/comun/cabecera.php');
	?>
		<main>
			<article>
			<?= $contenidoPrincipal ?>
			</article>
		</main>
	<?php
		require('includes/vistas/comun/pie.php');
	?>
	</div>
</body>
</html>
