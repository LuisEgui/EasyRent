<?php 


    session_start(); 

    $username = htmlspecialchars(trim(strip_tags($_REQUEST['nombre'])));
    $password =  htmlspecialchars(trim(strip_tags($_REQUEST['password'])));
    if($username == "user" && $password == "userpass"){ 
        $_SESSION["login"]=true;
        $_SESSION["nombre"]="Usuario";
    }else if($username == "admin" && $password == "adminpass"){
        $_SESSION["login"]=true; 
        $_SESSION["nombre"]="Administrador";
        $_SESSION["esAdmin"]=true;        
    }          
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Login</title>
</head>
<body>

    <div id="contenedor">   

    <main>
        <?php
            if(!isset($_SESSION["login"])){ 
                echo "<h1>ERROR</h1>";
                echo "<p>Nombre de usuario o contraseña incorrectos.</p>";                              
            }else{ 
                echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
                echo "<p>Usa el menú de la izquierda para navegar.</p>";      
            }
        ?>
    </main>
    </div>
  
</body>
</html>