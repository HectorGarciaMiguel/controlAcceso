<? include ("seguridad.php");

	if (!isset($_SESSION["admin"])) {
			//nos envía a la siguiente dirección en el caso de no poseer autorización
			echo '<script type="text/javascript">
			alert("No tiene permisos");
			window.location.assign("index.php");
			</script>';
	 }
?> 

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="estilo.css">
<body>
<div class="celda">

<? 	/*include ("seguridad.php");
	session_save_path("/home/u415857602/public_html/tmp");

	if (!isset($_SESSION["admin"])) {
		//nos envía a la siguiente dirección en el caso de no poseer autorización
		echo '<script type="text/javascript">
		alert("error, no permisos admin");
		window.location.assign("index.php");
		</script>';
	}*/
	
	$dni = $_POST['dni'];
	$guardar = $_POST['guardar'];
	
	include("dbconnect.php");
	
	if ($guardar == "si"){
		
		/* Realizamos la consulta SQL */
		$sql="SELECT * FROM usuario WHERE dni='$dni'";
		$result= mysqli_query($dbh, $sql) or die(mysql_error());
		if($row=mysqli_fetch_array($result)){

			$sql = "INSERT INTO contrato VALUES (
			'',
			'$row[dni]',
			'$row[name]',
			'$row[phone]',
			'$row[email]',
			'$row[local]',
			'$row[dateini]',
			'$row[datelast]')"; 

			if(!mysqli_query($dbh, $sql)){
				?> <p class="error">Error al insertar cliente al historial</p> <?	
			}else{
				?> <p class="correcto">Cliente insertado correctamente en el historial</p> <?
			}
		}	
	}
		
	$sql = "DELETE FROM usuario WHERE dni='$dni'"; 		 
	if(!mysqli_query($dbh, $sql)){
		?> <p class="error">Error al eliminar cliente</p> <?	
	}else{
		?> <p class="correcto">Cliente eliminado correctamente</p> <?
	}
	mysqli_close($dbh);	
	
	echo "<input class='boton' type='button' value='Cerrar' onclick='window.opener.location.reload(); window.close();'>";

	
?> 

    </div>

</body>
</html>
