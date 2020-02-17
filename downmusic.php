<?php 
   include('config.php');
   session_start();
   
   // Array que contiene una lista con los nombres de los productos para el select (desplegable)
   $canciones = listaCanciones($db);

?>

<html>
   
   <head>
      <title>REALIZAR PEDIDO </title>
   </head>
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
   
   <body>
   <h1>BIENVENIDO <?php echo $_SESSION['login_user']; ?></h1>
    <h2>TU ID DE USUARIO ES: <?php echo $_SESSION['id_user']; ?></h2>

	<form action="downmusic.php" method="post">
		<h1>Peliculas:</h1>
		<div>
			<select name="cancion">
				<?php forEach ($canciones as $cancion) : ?>
					<?php echo '<option>'. $cancion['Name'] . '</option>'; ?>
				<?php endforEach; ?>
			</select>
		</div>
		
		<div>
            <input type="submit" value="AGREGAR A LA CESTA" name="agregar">

            <input type="button" value="MENU PRINCIPAL" onclick="window.location.href='welcome.php'">
		</div>		
	</form>
	<!-- FIN DEL FORMULARIO -->
   </body>
   
</html>


<?php

if (isset($_POST) && !empty($_POST)) {
    $cancion = $_POST['cancion'];
	$sql = "SELECT TrackId, UnitPrice FROM Track WHERE Name = '$cancion'";
	$query  = mysqli_query($db, $sql);
	$resultado = mysqli_fetch_assoc($query);
    $idCancion = $resultado['TrackId'];
    $precioCancion = $resultado['UnitPrice'];

    
  // AGREGAR A LA CESTA DE LA COMPRA
	if (isset($_POST['agregar']) && !empty($_POST['agregar'])) {
            
        /*$pedido = array("idProducto" => $idCancion,
                "cantidad" => $cantidad,
                "totalProducto" => $totalCompra,
                "fechaCompra" => $fechaCompra);*/

           $_SESSION['cesta'][$idCancion]=$cancion;
    }

    $totalCompra = 0;


    echo "<table>
            <tr><th>ID CANCION</th><th>CANCION</th><th>PRECIO</th></tr>";
    foreach ($_SESSION['cesta'] as $idCancion => $cancion) {

        echo "<tr><td>$idCancion</td><td>$cancion</td><td>$precioCancion</td></tr>";

        $totalCompra = $totalCompra + $precioCancion;
        $_SESSION['total_compra'] = $totalCompra;
    }

    echo "</table>";

    echo "<b>TOTAL A PAGAR: " . $totalCompra . "€</b>";
    echo '<form action="finalizarCompra.php" method=="post"><input type="submit" value="COMPRAR"></form>';
	echo '<form action="borrarCarrito.php"><input type="submit" value="LIMPIAR CARRITO"></form>';
    
}

function listaCanciones($db) {
	$canciones = [];
	/*Extraigo todos los nombres de cancjones:*/
	$resultado = mysqli_query($db, "SELECT Name FROM Track LIMIT 20");
	while ($fila = mysqli_fetch_assoc($resultado)) {
		$canciones[] = $fila;
	}
	return $canciones;
}

?>
