<?php 
   include('config.php');
   session_start();
   
   echo "<h1>GRACIAS POR TU COMPRA " . $_SESSION['login_user'] . "</h1>";
   echo "<h2>TU ID DE USUARIO ES: " . $_SESSION['id_user'] . "</h2>";
   

   //seleccionamos el maximo id de invoice y le sumamos uno para ponder annadirlo posteriormente
   $sql = "SELECT MAX(InvoiceId) FROM Invoice";
	$query = mysqli_query($db, $sql);
	$result = mysqli_fetch_assoc($query);
   $idInvoice = $result['MAX(InvoiceId)'];
   $idInvoiceMax = $idInvoice + 1;

   //recupero el total de la compra y el id del usuario
   $totalCompra = $_SESSION['total_compra'];
   $idUsuario = $_SESSION['id_user'];

    //para utilizar la fecha actual, a la hora de insertar un valor, podemos utilizar sysdate() en vez de... 
   //$fechaCompra = date('Y-m-d H:i:s');

   //insertamos en la tabla invoce primero
      echo "idInvoiceMax: " . $idInvoiceMax . "<br>";
      echo "idUsuario: " . $idUsuario . "<br>";
      //echo "fechaCompra: " . $fechaCompra . "<br>";
      echo "totalCompra: " . $totalCompra . "<br><br>";

   $sql1= "INSERT INTO Invoice (InvoiceId, CustomerId, InvoiceDate, Total)
   VALUES ($idInvoiceMax, $idUsuario, now(), $totalCompra)";

   if (mysqli_query($db, $sql1)) {
      //echo "Se ha insertado correctamente.<br/>";
   }else {
      trigger_error("Error al insertar el pedido.<br/>");
      die();
   }

   //insertamos en la tabla invoceLine
   foreach ($_SESSION['cesta'] as $nombreCancion) {         
         
      $sqlMax = "SELECT MAX(InvoiceLineId) FROM InvoiceLine";
      $queryMax = mysqli_query($db, $sqlMax);
      $resultMax = mysqli_fetch_assoc($queryMax);
      $idInvoiceLine = $resultMax['MAX(InvoiceLineId)'];
      $idInvoiceLine = $idInvoiceLine + 1;

      $sqlPrecio = "SELECT UnitPrice, TrackId FROM Track WHERE Name='$nombreCancion'";
      $queryPrecio = mysqli_query($db, $sqlPrecio);
      $resultadoPrecio = mysqli_fetch_assoc($queryPrecio);
      $precioUnitario = $resultadoPrecio['UnitPrice'];
      $idCancion = $resultadoPrecio['TrackId'];

      $sql3 = "INSERT INTO InvoiceLine (InvoiceLineId, InvoiceId, TrackId, UnitPrice, Quantity) 
      VALUES(".$idInvoiceLine.", ".$idInvoiceMax.", ".$idCancion.", ".$precioUnitario.", 1);";
      if (mysqli_query($db, $sql3)) {
         //echo "Se ha insertado correctamente.<br/>";
      }else {
         trigger_error("Error al insertar los productos en el pedido.<br/>");
         die();
      }
   }

   echo '<script type="text/javascript">alert("COMPRA REALIZADA CON EXITO. GRACIAS POR CONFIAR EN NOSOTROS");</script>';
   $_SESSION['cesta'] = array();

?>

<input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'">