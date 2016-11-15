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
	
	$id_peticion = $_POST['id_peticion'];
	
	include("dbconnect.php");
		
	$sql = "DELETE FROM peticion WHERE id_peticion='$id_peticion'"; 		 
	if(!mysqli_query($dbh, $sql)){
		?> <p class="error">Error al eliminar petición</p> 	
			<form method="post" action="aplicacion_admin.php" >
    		<input class="boton" type="submit" value="Volver" />
    		</form ><?
	}
	mysqli_close($dbh);	
	
	header("Location: ".$_POST['back']);
	?>	
    </div>

</body>
</html>
