<?php
   include('session.php');
   
   //Sesion de inactividad
   $inactividad = 999;
    if(isset($_SESSION["timeout"])){
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: welcome.php");
        }
    }
	$_SESSION["timeout"] = time();
?>
<html">
   
   <head>
      <title>Bienvenido </title>
   </head>
   
   <body>

<h1>BIENVENIDO <?php echo $_SESSION['login_user']; ?></h1>
<h2>TU ID DE USUARIO ES: <?php echo $_SESSION['id_user']; ?></h2>

<input type="button" name="downmusic" value="DESCARGAR MUSICA" onclick="window.location.href='downmusic.php'"><br><br>
<input type="button" name="histfacturas" value="HISTORIAL DE FACTURAS" onclick="window.location.href='histfacturas.php'"><br><br>
<input type="button" name="facturas" value="CONSULTAR FACTURAS POR FECHAS" onclick="window.location.href='facturas.php'"><br><br>
<input type="button" name="ranking" value="RANKING DE CANCIONES MAS DESCARGADAS" onclick="window.location.href='ranking.php'"><br><br>


<input type="button" name="csesion" value="CERRAR SESION" onclick="window.location.href='logout.php'">
</body>
   
</html>