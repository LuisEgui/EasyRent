<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Formulario.php';
require_once __DIR__.'/includes/DamageService.php';
require_once __DIR__.'/includes/UserService.php';
require_once __DIR__.'/includes/Damage.php';
require_once __DIR__.'/includes/FormularioRegistroIncidente.php';

$tituloPagina = 'Incidentes';
$contenidoPrincipal = '<h1>Lista de incidentes</h1>';
$damageService = new DamageService($GLOBALS['db_damage_repository']);
$userService = new UserService($GLOBALS['db_user_repository'],$GLOBALS['db_image_repository'], );
$damages = $damageService->readAllDamages();
if (count($damages) > 0){
for ($i = 0; $i < count($damages); $i++) {
		$contenidoPrincipal .= <<<EOS
		<div class="v">
			<h1>Incidencia: 
		EOS;
		$contenidoPrincipal .= <<<EOS
			</h1>
			<p>Vehiculo: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getVehicle();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Usuario: 
		EOS;
        $usuario = $userService->readUserById($damages[$i]->getUser());
		$contenidoPrincipal .= $usuario->getEmail();
		$contenidoPrincipal .= <<<EOS
		</p>
		<p>Titulo: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getTitle();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Descripcion: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getDescription();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Imagen: 
		EOS;
        if($damages[$i]->getEvidenceDamage() != NULL){
		    $contenidoPrincipal .= $damages[$i]->getEvidenceDamage();
        } else {
            $contenidoPrincipal .= <<<EOS
                 No se incluye imagen
            EOS;
        }
        $contenidoPrincipal .= <<<EOS
		</p>
		EOS;
        $contenidoPrincipal .= <<<EOS
		<p>Area: 
		EOS;
		$contenidoPrincipal .= $damages[$i]->getArea();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>Type: 
		EOS;
        $contenidoPrincipal .= $damages[$i]->getType();
		$contenidoPrincipal .= <<<EOS
		</p> 
		<p>¿Está reparado?: 
		EOS;
        if($damages[$i]->getIsRepaired() == true){
            $contenidoPrincipal .= <<<EOS
            <p>SÍ</p>
            </p>
            EOS;
        } else {
            $contenidoPrincipal .= <<<EOS
            <p>NO</p>
            EOS;
        }
        $contenidoPrincipal .= <<<EOS
        <a href="borrarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damages[$i]->getId();
        $contenidoPrincipal .= <<<EOS
            ">Borrar</a>
        EOS;
        $contenidoPrincipal .= <<<EOS
            <a href="actualizarIncidente.php?id=
        EOS;
        $contenidoPrincipal .= $damages[$i]->getId();
        $contenidoPrincipal .= <<<EOS
            ">Editar</a> 
        EOS;
        $contenidoPrincipal .= <<<EOS
        </div>
        EOS;
        

}
}
$form = new FormularioRegistroIncidente();
	$htmlFormRegMessage = $form->gestiona();

	$tituloPagina = 'Agregar incidente';

	$contenidoPrincipal .= <<<EOS
	<h1>Nuevo incidente</h1>
	$htmlFormRegMessage
	EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
