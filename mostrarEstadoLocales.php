<? 
function mostrarEstadoLocales($user){
	include("dbconnect.php");
			
		/* Realizamos la consulta SQL */
		$sql="SELECT * FROM usuario WHERE dni='$user'";
		$result= mysqli_query($dbh, $sql) or die(mysql_error());
 
 		if (mysqli_num_rows($result)==1){
			$row=mysqli_fetch_array($result);

			$permits = $row['permits'];
			$local = $row['local'];
		
			$sql2="SELECT * FROM sensores_presencia ORDER BY local ASC";
			$result2= mysqli_query($dbh, $sql2) or die(mysql_error());	
			$estado = array();
			for($i=0 ; $i<5 ; $i++){
				$row2=mysqli_fetch_array($result2);
				$estado[$i] = $row2['estado'];
			}
			mysqli_free_result($result2); 
		}
		mysqli_free_result($result);
		mysqli_close($dbh);
		
	
		
	echo "<table width='591' height='235' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td rowspan='2'>";
				
				if ($permits==1 || ($permits==0 && $local==4)){ 
					if ($estado[3]==1){
						echo "<img src='recursos/locales/locales_4ON.jpg' width='130' height='119' alt=''></td>";
					}else{
						echo "<img src='recursos/locales/locales_4OFF.jpg' width='130' height='119' alt=''></td>";
					}
				}else{
					echo "<img src='recursos/locales/locales_4.jpg' width='130' height='119' alt=''></td>";
				}
				
			
			echo "<td rowspan='3'>";
			
				if ($permits==1 || ($permits==0 && $local==3)){ 
					if ($estado[2]==1){
						echo "<img src='recursos/locales/locales_3ON.jpg' width='188' height='187' alt=''></td>";
					}else{
						echo "<img src='recursos/locales/locales_3OFF.jpg' width='188' height='187' alt=''></td>";
					}
				}else{
					echo "<img src='recursos/locales/locales_3.jpg' width='188' height='187' alt=''></td>";
				}
				
			echo "<td rowspan='3'>";
				
				if ($permits==1 || ($permits==0 && $local==2)){ 
					if ($estado[1]==1){
						echo "<img src='recursos/locales/locales_2ON.jpg' width='160' height='187' alt=''></td>";
					}else{
						echo "<img src='recursos/locales/locales_2OFF.jpg' width='160' height='187' alt=''></td>";
					}
				}else{
					echo "<img src='recursos/locales/locales_2.jpg' width='160' height='187' alt=''></td>";
				}
				
				
				
			echo "<td>";
				
				if ($permits==1 || ($permits==0 && $local==1)){ 
					if ($estado[0]==1){
						echo "<img src='recursos/locales/locales_1ON.jpg' width='112' height='109' alt=''></td>";
					}else{
						echo "<img src='recursos/locales/locales_1OFF.jpg' width='112' height='109' alt=''></td>";
					}
				}else{
					echo "<img src='recursos/locales/locales_1.jpg' width='112' height='109' alt=''></td>";
				}
				
			echo "
			<td>
				<img src='recursos/locales/espacio.gif' width='1' height='109' alt=''></td>
		</tr>
		<tr>
			<td rowspan='3'>
				<img src='recursos/locales/entrada.jpg' width='112' height='126' alt=''></td>
			<td>
				<img src='recursos/locales/espacio.gif' width='1' height='10' alt=''></td>
				
		</tr>
		<tr>
			<td <td rowspan='2'>";
		
				if ($permits==1 || ($permits==0 && $local==5)){ 
					if ($estado[4]==1){
						echo "<img src='recursos/locales/locales_5ON.jpg' width='130' height='116' alt=''></td>";
					}else{
						echo "<img src='recursos/locales/locales_5OFF.jpg' width='130' height='116' alt=''></td>";
					}
				}else{
					echo "<img src='recursos/locales/locales_5.jpg' width='130' height='116' alt=''></td>";
				}
		
		echo "<td>
				<img src='recursos/locales/espacio.gif' width='1' height='68' alt=''></td>
	
		</tr>
		<tr>
			<td colspan='2'>
				<img src='recursos/locales/pasillo.jpg' width='348' height='48' alt=''></td>
			<td>
				<img src='recursos/locales/espacio.gif' width='1' height='48' alt=''></td>
		</tr>
	</table>"; 
}

?>
			
			
