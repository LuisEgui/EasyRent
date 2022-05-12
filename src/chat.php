<?php

session_start();

function createForm(){
?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table>
          <tr><td colspan="2">Ingrese su nombre para iniciar sesión!</td></tr>
          <tr><td>Tu nombre: </td>
          <td><input class="text" type="text" name="name" /></td></tr>
          <tr><td colspan="2">
             <input class="text" type="submit" name="submitBtn" value="Login" />
          </td></tr>
        </table>
      </form>
<?php
}

if (isset($_GET['u'])){
   unset($_SESSION['nickname']);
}

// Procesar información de inicio de sesión
if (isset($_POST['submitBtn'])){
      $name    = isset($_POST['name']) ? $_POST['name'] : "Unnamed";
      if($_SESSION['esAdmin']) $name = "Administrador -> " . $name;
      $_SESSION['nickname'] = $name;
}

$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : "Hidden";   
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <title>Chat de incidencias</title>
   <link href="/src/includes/estilo.css" rel="stylesheet" type="text/css" />
   <link href="/style/globe.png" rel="shortcut icon">
    <script>
      var httpObject = null;
      var link = "";
      var timerID = 0;
      var nickName = "<?php echo $nickname; ?>";

      // Obtener el objeto HTTP
      function getHTTPObject(){
         if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
         else if (window.XMLHttpRequest) return new XMLHttpRequest();
         else {
            alert("Tu navegador no soporta AJAX.");
            return null;
         }
      }   

      // Cambiar el valor del campo outputText
      function setOutput(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML += response;
            objDiv.scrollTop = objDiv.scrollHeight;
            var inpObj = document.getElementById("msg");
            inpObj.value = "";
            inpObj.focus();
         }
      }

      // Cambiar el valor del campo outputText
      function setAll(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML = response;
            objDiv.scrollTop = objDiv.scrollHeight;
         }
      }

      // Implementar la lógica 
      function doWork(){    
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "chatMessage.php?nick="+nickName+"&msg="+document.getElementById('msg').value;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
      }
 
      // Implementar la lógica   
      function doReload(){    
         httpObject = getHTTPObject();
         var randomnumber=Math.floor(Math.random()*10000);
         if (httpObject != null) {
            link = "chatMessage.php?all=1&rnd="+randomnumber;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setAll;
            httpObject.send(null);
         }
      }

      function UpdateTimer() {
         doReload();   
         timerID = setTimeout("UpdateTimer()", 5000);
      }
    
      function fin(){
        httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "finChat.php";
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
         UpdateTimer();  
      }
    
      function keypressed(e){
         if(e.keyCode=='13'){
            doWork();
         }
      }

    </script>   
</head>
   
<body onload="UpdateTimer();">
    <div id="main">
      <div id="caption"><h1>Chat de incidencias</h1></div>
      <div id="icon">&nbsp;</div>
<?php 

if (!isset($_SESSION['nickname']) ){ 
    createForm();
} else  { 
      $name    = isset($_POST['name']) ? $_POST['name'] : "Unnamed";
      $_SESSION['nickname'] = $name;
    ?>
      
     <div id="result">
     <?php 
        $data = file("msg.txt");
        foreach ($data as $line) {
        	echo $line;
        }
     ?>
      </div>
      <div id="sender" onkeyup="keypressed(event);">
         Mensaje: <input type="text" name="msg" size="30" id="msg" />
         <button onclick="doWork();">Enviar</button>
      </div>  
      <div>
      <button onclick="fin();">Finalizar chat</button>
    </div>
    <div>
    <a href="../index.php">Salir</a>
      </div>
<?php            
}

?>
    </div>
</body>   

