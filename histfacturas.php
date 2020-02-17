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
   

<?php

    $idUsuario = $_SESSION['id_user'];

        $sql = "SELECT invoiceId, InvoiceDate, Total FROM Invoice WHERE CustomerId = '$idUsuario'";
		$query = mysqli_query($db, $sql);
		
		echo "<br/>";
		while($row = mysqli_fetch_assoc($query)) {
			echo "<table border='1'>";
			echo "<tr><th>ID de pedido</th><th>Fecha de pedido</th><th>Total</th></tr>";
			echo "<tr><td>".$row['invoiceId']."</td><td>".$row['InvoiceDate']."</td><td>".$row['Total']."</td></tr>";
            echo "</table>";
            
            $result = $row['invoiceId'];
            
			$sql2 = "SELECT InvoiceLine.InvoiceId, Track.Name, InvoiceLine.UnitPrice, InvoiceLine.Quantity
            FROM Invoice, InvoiceLine, Track
            WHERE Invoice.InvoiceId = InvoiceLine.InvoiceId AND InvoiceLine.TrackId = Track.TrackId
            AND Invoice.customerId = '$idUsuario' AND '$result' = InvoiceLine.InvoiceId";
			$query2 = mysqli_query($db, $sql2);
			
			echo "<table border='1'>";
			echo "<tr><th>ID de pedido</th><th>Nombre de cancion</th><th>Precio por cancion</th><th>Cantidad pedida</th></tr>";
			while($row2 = mysqli_fetch_assoc($query2)) {
				echo "<tr><td>".$row2['InvoiceId']."</td><td>".$row2['Name']."</td><td>".$row2['UnitPrice']."</td><td>".$row2['Quantity']."</td></tr>";
			}
			echo "</table>";
			echo "<br/><br/>";
        }
        
?>
    <input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'"><br>

</html>