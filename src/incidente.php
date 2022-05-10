<?php

require_once '../vendor/autoload.php';
require_once __DIR__.'/includes/config/config.php';

$tituloPagina = 'Generar Incidente';
$contenidoPrincipal = <<< EOS
<form action="perfil.php" method="POST">
    <div>
        <label for="motivo">Motivo incidente: </label>
        <select id="motivo" name="motivoIncidente">
            <option value="accidente">Accidente</option>
            <option value="rueda">Rueda pinchada</option>
            <option value="funcionamiento">No arranca</option>
            <option value="desperfecto">Desperfecto generado</option>
        </select>
    </div>
    <div>
        <label for="nres">Número de reserva: </label>
        <input type="text" id="nres" name="numeroReserva" />
    </div>
    <div>
        <label for="asunto">Asusnto: </label>
        <input type="text" id="asunto" name="asunto"/>
    </div>
    <div>
    <div>
        <label for="mensaje">Mensaje: </label>
        <input type="text" id="mensaje" name="mensaje" />
    </div>
    <div>
        <input type="submit" name="enviar" value="Enviar"/>
    </div>
</form>
EOS;

include 'includes/vistas/plantillas/plantilla.php';
