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
	 
	 include("dbconnect.php");

		/* Realizamos la consulta SQL */
		$sql="SELECT * FROM contrato ORDER by id_contrato DESC";
		$result= mysqli_query($dbh, $sql) or die(mysql_error());
		//if(mysqli_num_rows($result)

		echo "<table border=1 cellpadding=4 cellspacing=0>";
		/*Priemro los encabezados*/
 		echo "<tr>
         <th> Número de contrato </th>
		 <th> DNI </th>
		 <th> Nombre </th>
		 <th> Movil </th>
		 <th> Correo </th>
 		 <th> Local que ocupó </th>
		 <th> Fecha inicial </th>
		 <th> Fecha final </th>
		 <th> Eliminar contrato </th>
		 </tr>";

		 while($row=mysqli_fetch_array($result)){
			/*Y ahora todos los registros */
			?><tr>
			 <td align="center"> <? echo $row['id_contrato']; ?></td>
			 <td align="center"> <? echo $row['dni']; ?></td>
			 <td align="center"> <? echo $row['name']; ?> </td>
			 <td align="center"> <? echo $row['phone']; ?> </td>
			 <td align="center"> <? echo $row['email']; ?> </td>
      		 <td align="center"> <? echo $row['local']; ?> </td>
			 <td align="center"> <? echo date("d-m-Y", strtotime($row['dateini'])); ?> </td>
			 <td align="center"> <? echo date("d-m-Y", strtotime($row['datelast'])); ?></td>
			 <td align="center">
                        <form method="post" action="eliminarContrato.php" onClick="javascript: return confirm('¿Estas seguro?');">
                        <input type="hidden" name="id_contrato" value="<? echo $row['id_contrato'] ?>" />
                        <input class="boton" type="submit" value="Eliminar datos del contrato" />
                        </form></td>
             </tr><?
		 }
		echo "</table>"; 
		mysqli_free_result($result); 
		mysqli_close($dbh)
?> 
</div>

</body>
</html>