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

<? 
	 
	 include("dbconnect.php");

		/* Realizamos la consulta SQL */
		$sql="SELECT * FROM sensores_apertura ORDER by fecha DESC";
		$result= mysqli_query($dbh, $sql) or die(mysql_error());
		//if(mysqli_num_rows($result)

		echo "<table border=1 cellpadding=4 cellspacing=0>";
		/*Priemro los encabezados*/
 		echo "<tr>
         <th> Fecha </th>
		 <th> Local </th>
		 </tr>";

		 while($row=mysqli_fetch_array($result)){
			/*Y ahora todos los registros */
			?><tr>
			 <td align="center"> <? echo $row['fecha']; ?></td>
			 <td align="center"> <? echo ($row['local']==0) ? "Puerta principal" :  "Local ".$row['local']; ?></td>
			 
             </tr><?
		 }
		echo "</table>"; 
		mysqli_free_result($result); 
		mysqli_close($dbh)
?> 
</div>

</body>
</html>