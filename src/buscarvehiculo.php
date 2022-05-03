<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Buscar Vehiculo';

$contenidoPrincipal = <<<EOS
<div class="buscadorVehiculo">
    <form id="inrow" action="buscarvehiculo.php" method="POST">
    <div>
        <label for="ubi">Ubicación de recogida: </label>
        <input type="text" id="ubi" name="ubicacion" />
    </div>
    <div>
        <label for="rec">Recogida: </label>
        <input type="date" id="rec" name="recogida" />
    </div>
    <div>
        <label for="dev">Devolución: </label>
        <input type="date" id="dev" name="devolucion"/>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Filtrar</button>
      <div class="dropdown-content">
        <a>Modelo</a>
        <a>Nº Asientos</a>
        <a>Accesorios</a>
        <a>Combustible</a>
      </div>
		</div>
    </form>
	</div>

    <div class="vehiculos">
        <div id="vehiculo">
            <h3>Vehiculo 1</h3>
            <p>
            Categoria
            </p>
            <p>
            Recogida
            </p>
                <h4>TARIFA</h4>
                <h4>20€</h4>
                <a href="selectVehiculo.php">Seleccionar</a>
        </div>

    </div>


EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
