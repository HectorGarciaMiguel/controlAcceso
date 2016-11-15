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
<? /*include ("seguridad.php");
	session_save_path("/home/u415857602/public_html/tmp");

	if (!isset($_SESSION["admin"])) {
		//nos envía a la siguiente dirección en el caso de no poseer autorización
		echo '<script type="text/javascript">
		alert("error, no permisos admin");
		window.location.assign("index.php");
		</script>';
	}*/	
		?>	
			<form method="post" action="registrarCliente.php">
            <table border=0>
            <tr><td>DNI (*sin letra) </td><td><input type="number" name="dni" value="<? echo $_POST['dni']; ?>" size="9" maxlength="9"> </td></tr>
            <tr><td>Nombre y Apellidos </td><td><input type="text" name="name" value="<? echo $_POST['name']; ?>" maxlength="50"> </td></tr>
            <tr><td>Movil </td><td><input type="number" name="phone" value="<? echo $_POST['phone']; ?>" size="8" maxlength="9"> </td></tr>
            <tr><td>Correo electrónico </td><td><input type="text" name="email" value="<? echo $_POST['email']; ?>" maxlength="50"> </td></tr>
            <tr><td>Local a asignar </td><td> <? echo localesDisponibles(); ?></td></tr>
            <tr><td>Fecha de inicio <input type="date" name="dateini" value="<? echo $_POST['dateini']; ?>"></td>
            <td>Fecha de fin <input type="date" name="datelast" value="<? echo $_POST['datelast']; ?>"></td></tr>
            <tr><td><input class="boton" type="submit" value="Registrar petición como cliente" /></td></tr>
            <input type="hidden" name="originaldni" value="<? echo $_POST['dni']; ?>"/>
            <input type="hidden" name="id_peticion" value="<? echo $_POST['id_peticion']; ?>"/>
            </table>
            </form>
        
        
<?
function localesDisponibles(){
	 
	include("dbconnect.php");

	$sql="SELECT * FROM usuario WHERE permits='0' ORDER BY local ASC";
	$result= mysqli_query($dbh, $sql) or die(mysql_error());
	$nrows=mysqli_num_rows($result);
	if($nrows==5){
		echo "No hay locales disponibles.";
	}else{
		$localesOcupados = array();
		$j=0;
		while($row=mysqli_fetch_array($result) ){
			$localesOcupados[$j]=$row['local'];
			$j++;
		}
		
		$j=0;
		for ($i=1 ; $i <= 5 ; $i++){
			if ($i==$localesOcupados[$j]){
				echo  "| " . $i . " <input type='radio' name='local' value='' disabled /> |";
				$j++; 
			}else{
				echo  "| " . $i . " <input type='radio' name='local' value= '" . $i . "' /> |"; 
			}
		}
		
	}
	 
	 mysqli_free_result($result); 
	 mysqli_close($dbh);
	 
 }

?>

</div>

</body>
</html>
