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
<head> 
<title>Macroacusti - Acceso a locales de ensayo</title> 
</head> 
<body> 

<div class="titulo">
	<h2 align="center">Acceso a locales de ensayo 
	<a href="http://www.macroacusti.es/"><img src="recursos/logo.png" width="200px" align="right" ></a>
	<br><p><h4 class="nodestacado">Modo administrador</h4></p></h2>


	<div class="vertical" id="izquierda">
		<? mostrarPeticiones(); ?>      
	</div>
        
	<div class="linea" id="derecha" style="border:0px;">
        <form method="post" action="salir.php" onClick="javascript: return confirm('¿Estas seguro de cerrar sesion?');">
       	<input class="boton" type="submit" value="Salir" />
       	</form>
	</div>
</div>

<div id="centrado">

	<div class="celda">
		<h3 align="center">Apertura de puertas</h3>
		<div>
        	<div class="vertical">
            	<h4> Puerta principal </h4>
            	<form method="post" action="abrirPuerta.php">
               	<input type="hidden" name="local" value="0"> 
            	<input class="boton" type="submit" value="Abrir entrada" />
            	</form>
        	</div>
        
        	<div class="vertical">
           	 	<h4> Locales </h4>
            	<form method="post" action="abrirPuerta.php"> 
            	Seleccionar local: <br>
            	1 <input type="radio" name="local" value="1" checked> 
            	2 <input type="radio" name="local" value="2"> 
            	3 <input type="radio" name="local" value="3"> 
            	4 <input type="radio" name="local" value="4">  
            	5 <input type="radio" name="local" value="5"> <br><br>
            	<input class="boton" type="submit" value="Abrir" />
            	</form>
         	</div>
         
         	<div class="vertical">
            	<h4> Registro de aperturas </h4>
            	<form method="post" action="mostrarRegistroAperturas.php" target='popup'
             	onsubmit="window.open('', 'popup', 'width = 310, height = 620, top = 100, left = 400')">
            	<input class="boton" type="submit" value="Ver registro" />
            	</form>
        	</div>
    	</div>
   	
    	<div>
	    	<div class="vertical">
     			<h4>Estado actual de los locales</h4>
            	<? require_once("mostrarEstadoLocales.php");
				$dni=$_SESSION["dni"];
            	mostrarEstadoLocales($dni); ?> 
     		</div>
     	</div>
	</div>

	<div class="celda">
		<h3 align="center">Control de clientes</h3>

    	<div class="vertical">
        	<h4>Historial de contratos</h4>
        	<form method="post" action="historialContratos.php" target="popup"
        	onsubmit="window.open('', 'popup', 'width = 1000, height = 400, top = 210, left = 300, scrollbars=1')">
        	<input class="boton" type="submit" value="Mostrar"  />
        	</form>
    	</div>
	
    	<div class="vertical">
			<h4>Registro de los contratos actuales</h4>
			<? mostrarContratosActuales(); ?>
   	 	</div>

	</div>

</div>

</body> 
</html>


<?php
	function mostrarPeticiones(){
		
                include("dbconnect.php");
        
                /* Realizamos la consulta SQL */
                $sql="SELECT * FROM peticion ORDER BY id_peticion ASC";
                $result= mysqli_query($dbh, $sql) or die(mysql_error());
                $nrows=mysqli_num_rows($result);
                if($nrows==0){
					echo "<h4 align='left'>";
					echo "<img width='50' src='recursos/arrowno.png'> Bandeja de peticiones vacía</h4>";
                }else{
                	if ($_GET["request"]=="1"){		  
							echo "<h4 align='left'><a href='aplicacion_admin.php'><img class='up' width='50' src='recursos/arrownotup.png'></a> Peticiones pendientes</h4><br>";

                          	echo "<table border=1 cellpadding=4 cellspacing=0>";
                              /*Priemro los encabezados*/
                            echo "<br><tr>
                             <th> Fecha de petición </th>
                             <th> DNI </th>
                             <th> Nombre </th>
                             <th> Móvil </th>
                             <th> Correo </th>
                             <th> Fecha inicial </th>
                             <th> Fecha final </th>
                             <th> Registrar cliente </th>
                             <th> Eliminar petición </th>
                             </tr>";
                    
                             while ($row=mysqli_fetch_array($result)){	
                                /*Y ahora todos los registros */
                                echo "<tr>
                                 <td align='center'>". $row['date_peticion'] ."</td>
                                 <td align='center'>". $row['dni'] ."</td>
                                 <td align='center'>". $row['name'] ."</td>
                                 <td align='center'>". $row['phone'] ."</td>
                                 <td align='center'>". $row['email'] ."</td>
                                 <td align='center'>". date('d-m-Y', strtotime($row['dateini'])) ."</td>
                                 <td align='center'>". date('d-m-Y', strtotime($row['datelast'])) ."</td>
                                 <td align='center'>
                                     <form method='post' action='formularioPeticion.php' target='popup'
                                        onsubmit=\"window.open('', 'popup', 'width = 630, height = 320, top = 200, left = 300')\">
                                        <input type='hidden' name='id_peticion' value='".$row['id_peticion'] ."' />
                                        <input type='hidden' name='dni' value='". $row['dni'] ."' />
                                        <input type='hidden' name='name' value='". $row['name'] ."' />
                                        <input type='hidden' name='phone' value='". $row['phone'] ."' />
                                        <input type='hidden' name='email' value='". $row['email'] ."' />
                                        <input type='hidden' name='dateini' value='". $row['dateini'] ."' />
                                        <input type='hidden' name='datelast' value='". $row['datelast'] ."' />
                                        <input class='boton' type='submit' value='Registrar petición' />
                                     </form></td>
                                  <td align='center'>
                                      <form method='post' action='eliminarPeticion.php' onClick=\"javascript: return confirm('¿Estas seguro?');\">  
                                        <input type='hidden' name='id_peticion' value='". $row['id_peticion'] ."' />
                                        <input type='hidden' name='back' value='". $_SERVER['REQUEST_URI'] ."' />
                                        <input class='boton' type='submit' value='Eliminar petición' />
                                      </form></td>  </tr>";
                            	} 
                            echo "</table>";
					}else{
						echo "<h4 align='left'><a href='aplicacion_admin.php?request=1'><img class='down' width='50' src='recursos/arrownotdown.png'></a> Peticiones pendientes</h4>";
					}
                }
             mysqli_free_result($result); 
             mysqli_close($dbh);
  	}
?>


<?php

	function mostrarContratosActuales(){
                include("dbconnect.php");
        
                /* Realizamos la consulta SQL */
                $sql="select * from usuario where permits='0' order by local asc";
                $result= mysqli_query($dbh, $sql) or die(mysql_error());
                //if(mysqli_num_rows($result)
        
                echo "<table border=1 cellpadding=4 cellspacing=0>";
                /*Priemro los encabezados*/
                echo "<tr>
                 <th> Local de ensayo </th>
                 <th> DNI </th>
                 <th> Nombre </th>
                 <th> Móvil </th>
                 <th> Correo </th>
                 <th> Fecha inicial </th>
                 <th> Fecha final </th>
                 <th> Editar cliente </th>
                 <th> Terminar contrato </th>
                 </tr>";
        
                 $row=mysqli_fetch_array($result);
                 for ($i = 1; $i < 6; $i++){	
                    /*Y ahora todos los registros */
                        if ($i==$row['local']){
                            echo "<tr>
                             <td align='center'>". $row['local'] ."</td>
                             <td align='center'>". $row['dni'] ."</td>
                             <td align='center'>". $row['name'] ."</td>
                             <td align='center'>". $row['phone'] ."</td>
                             <td align='center'>". $row['email'] ."</td>
                             <td align='center'>". date('d-m-Y', strtotime($row['dateini'])) ."</td>
                             <td align='center'>". date('d-m-Y', strtotime($row['datelast'])) ."</td>
                             <td align='center'>
                                <form method='post' action='formularioCliente.php' target='popup'
                                onsubmit=\"window.open('', 'popup', 'width = 550, height = 320, top = 200, left = 300')\">
                                <input type='hidden' name='tipo' value='editar' />
                                <input type='hidden' name='local' value='". $row['local'] ."' />
                                <input type='hidden' name='dni' value='". $row['dni'] ."' />
                                <input type='hidden' name='name' value='". $row['name'] ."' />
                                <input type='hidden' name='phone' value='". $row['phone'] ."' />
                                <input type='hidden' name='email' value='". $row['email'] ."' />
                                <input type='hidden' name='dateini' value='". $row['dateini'] ."' />
                                <input type='hidden' name='datelast' value='". $row['datelast'] ."' />
                                <input class='boton' type='submit' value='Editar datos cliente' />
                                </form></td>
                             <td align='center'>
                                <form method='post' action='formularioCliente.php' target='popup' 
								onsubmit=\"window.open('', 'popup', 'width = 400, height = 210, top = 200, left = 300')\">
                                <input type='hidden' name='tipo' value='terminar' />
                                <input type='hidden' name='dni' value='". $row['dni'] ."' /> 
                                <input type='hidden' name='name' value='". $row['name'] ."' />                                               
                                <input class='boton' type='submit' value='Terminar contrato' />
                                </form></td>
                            
                            </tr>";
                            
							 					 
                            $row=mysqli_fetch_array($result);
                            
                        }else{
                            echo "<tr> 
                            <td align='center'>". $i ."</td>
                            <td colspan='8' align='center'>
                            <form method='post' action='formularioCliente.php' target='popup'
                            onsubmit=\"window.open('', 'popup', 'width = 550, height = 320, top = 200, left = 300')\">
                            <input type='hidden' name='tipo' value='registrar' />
                            <input type='hidden' name='local' value='". $i ."' />
                            <input class='boton' type='submit' value='Registrar cliente en local ". $i."' />
                            </form>
                            </td></tr>";
                            
                        }
                 }
                echo "</table>"; 
                mysqli_free_result($result); 
                mysqli_close($dbh);
				
	}
?>

<? 

function mostrarEstadoLocales1($user){
		

echo "<table width='591' height='235' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td rowspan='2'>
			<img src='recursos/locales/locales_4ON.jpg' width='130' height='119' alt=''></td>
		<td rowspan='3'>
			<img src='recursos/locales/locales_3OFF.jpg' width='188' height='187' alt=''></td>
		<td rowspan='3'>
			<img src='recursos/locales/locales_2ON.jpg' width='160' height='187' alt=''></td>
		<td>
			<img src='recursos/locales/locales_1OFF.jpg' width='112' height='109' alt=''></td>
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
		<td <td rowspan='2'>
			<img src='recursos/locales/locales_5OFF.jpg' width='130' height='116' alt=''></td>
		<td>
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
