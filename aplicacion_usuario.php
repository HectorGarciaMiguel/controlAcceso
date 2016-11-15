<? include ("seguridad.php");

	if (!isset($_SESSION["user"])) {
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
	<a href="http://www.macroacusti.es/"><img src="recursos/logo.png" width="200px" align="right" ></a></h2>
             
    <h4 align="center" class="nodestacado">Acceso a local <? $local = getLocal($_SESSION["dni"]); echo $local ?></h4>
    
    <div class="vertical" id="izquierda" style="border:0px;"></div>
    
	<div class="vertical" id="derecha" style="border:0px;  margin:5px">
    	   	<form method="post" action="salir.php" onClick="javascript: return confirm('¿Estas seguro de cerrar sesion?');">
	       	<input class="boton" type="submit" value="Salir" />
       		</form>
	</div>

</div>
<div id="centrado">
<ul><li>
	<div class="celda" >
		<h3 align="center">Apertura de puertas</h3>
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
            	<input type="hidden" name="local" value="<? $local ?>"> 
            	<input class="boton" type="submit" value="Abrir local <? echo $local; ?>" />
            	</form>
             </div>
    </div>
</li><li>       
	<div class="celda" >
     			<h4>Estado actual del local <? echo $local; ?></h4>
            	<? require_once("mostrarEstadoLocales.php");
				$dni=$_SESSION["dni"];
            	mostrarEstadoLocales($dni); ?> 
	</div>
</li></ul>
</div>
</body>
</html>
<?  
function getLocal($usuario){
	include("dbconnect.php");
	$ssql = "SELECT local FROM usuario WHERE dni='$usuario'"; 
	//Ejecuto la sentencia 
	$rs = mysqli_query($dbh, $ssql); 
	//vemos si el usuario y contraseña es válido  
	$local=0;
	if (mysqli_num_rows($rs)==1){ 
		$row=mysqli_fetch_array($rs);
		$local = $row['local'];
	}
	mysqli_free_result($rs); 
	mysqli_close($dbh);
	return $local;
}
?>