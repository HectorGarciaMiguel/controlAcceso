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
	
	$id_contrato = $_POST['id_contrato'];
	
	include("dbconnect.php");
		
	$sql = "DELETE FROM contrato WHERE id_contrato='$id_contrato'"; 		 
	if(!mysqli_query($dbh, $sql)){
		?> <p class="error">Error al eliminar cliente</p> <?	
	}else{
		?> <p class="correcto">Cliente eliminado correctamente</p> <?
	}
	mysqli_close($dbh);	
	
	?>	
    
    <form method="post" action="historialContratos.php" >
    <input class="boton" type="submit" value="Volver" />
    </form>

</div>

</body>
</html>