<?php 
   include('config.php');
   session_start();

?>

<html>
   
   <head>
      <title>HISTORIAL DE FACTURAS</title>
      <style>
       table{
           text-align: center;
           border:1px solid black;
           width:80%;
       }
       th, td{
        width:25%;
        border:1px solid black;
       }
   </style>
   </head>
   
   <body>
   <h1>HISTORIAL DE FACTURAS DEL USUARIO <?php echo $_SESSION['login_user']; ?></h1>
    <h2>TU ID DE USUARIO ES: <?php echo $_SESSION['id_user']; ?></h2>	

    <input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'"><br>

    <form action="facturas.php" method="post">
		<h4>ELEGIR FECHAS PARA CONSULTAR FACTURAS</h4>
		    Fecha inicial: <input type="date" name="fechaI">
			<br/>
			Fecha final: <input type="date" name="fechaF">
			<br/>
		
		<div>
            <input type="submit" value="CONSULTAR FACTURAS" name="consultar">

            <input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'">
		</div>		
	</form>
   

<?php

    $idUsuario = $_SESSION['id_user'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $fechaInicial = mysqli_real_escape_string($db,$_POST['fechaI']);
        $fechaFinal = mysqli_real_escape_string($db,$_POST['fechaF']);

        //echo $fechaInicial . " " . $fechaFinal;

        $sql = "SELECT invoiceId, InvoiceDate, Total FROM Invoice WHERE CustomerId = '$idUsuario'
        AND InvoiceDate BETWEEN '$fechaInicial' AND '$fechaFinal'";
        $query = mysqli_query($db, $sql);

		echo '<br/>';
		echo "<h3 style='color: black;'>HISTORIAL DE TUS PEDIDOS ENTRE '$fechaInicial' Y '$fechaFinal'</h3>";
		echo '<br/>';

        while($row = mysqli_fetch_assoc($query)) {
			echo "<table border='1'>";
			echo "<tr><th>ID DE PEDIDO</th><th>FECHA DE PEDIDO</th><th>TOTAL</th></tr>";
			echo "<tr><td>".$row['invoiceId']."</td><td>".$row['InvoiceDate']."</td><td>".$row['Total']."</td></tr>";
			echo "</table>";
			$result = $row['invoiceId'];
			$sql2 = "SELECT InvoiceLine.InvoiceId, Track.Name, InvoiceLine.UnitPrice, InvoiceLine.Quantity
            FROM Invoice, InvoiceLine, Track WHERE Invoice.InvoiceId = InvoiceLine.InvoiceId
            AND InvoiceLine.TrackId = Track.TrackId AND Invoice.customerId = '$idUsuario'
            AND '$result' = InvoiceLine.InvoiceId";
			$query2 = mysqli_query($db, $sql2);
			
			echo "<table border='1'>";
			echo "<tr><th>ID DE PEDIDO</th><th>NOMBRE DE CANCION</th><th>PRECIO DE CANCION</th><th>CANTIDAD PEDIDA</th></tr>";
			while($row2 = mysqli_fetch_assoc($query2)) {
				echo "<tr><td>".$row2['InvoiceId']."</td><td>".$row2['Name']."</td><td>".$row2['UnitPrice']."</td><td>".$row2['Quantity']."</td></tr>";
			}
			echo "</table>";
			echo "<br/><br/>";
		}


    }


        
?>
    <br><br><input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'">

</html>