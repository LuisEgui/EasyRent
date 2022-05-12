
<?php

 require_once '../vendor/autoload.php';
 require_once __DIR__.'/includes/config/config.php';

 $tituloPagina = 'Admin';

 $contenidoPrincipal = <<<EOS
    <div class="administracion" >
        <h2 class="tituloPagina">Administrar</h2>
    </div>
    <div class="cuadriculaAdmin">
        <a class="infoAdmin" href="vehiclesAdmin.php">Administrar vehiculos</a>

        <a class="infoAdmin" href="modelsAdmin.php">Administrar modelo</a>

        <a class="infoAdmin" href="reservasAdmin.php">Administrar reservas</a>

        <a class="infoAdmin" href="nuevoAnuncio.php">Añadir anuncio</a>

        <a class="infoAdmin" href="modificarAnuncios.php">Modificar anuncios</a>

    </div>
 EOS;

 require __DIR__.'/includes/vistas/plantillas/plantilla.php';
