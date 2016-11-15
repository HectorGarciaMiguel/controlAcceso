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
	require_once 'validar.php';
	$errores = array();
	  
	$dni = ltrim($_POST['dni'], '0');
	$originaldni = $_POST['originaldni'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$dateini = date("Y-m-d", strtotime($_POST['dateini']));
 	$datelast = date("Y-m-d", strtotime($_POST['datelast']));
		
	/********************/
 	$opciones_dni = array('options' => array('min_range' => 1,'max_range' => 999999999));
   	if (!validarEntero($dni, $opciones_dni)) {
      $errores[] = 'El campo dni es incorrecto.';
   	}
	if (!validaRequerido($name)) {
      $errores[] = 'El campo nombre es incorrecto.';
   	}
   $opciones_telefono = array('options' => array('min_range' => 600000000,'max_range' => 999999999));
   if (!validarEntero($phone, $opciones_telefono)) {
      $errores[] = 'El campo movil es incorrecto.';
   }
   if (!validaEmail($email)) {
      $errores[] = 'El campo email es incorrecto.';
   }
	/************************/
	if (!$errores){
		include("dbconnect.php");
		$ssql = "UPDATE usuario SET dni='$dni' , 
									name='$name' ,
									phone='$phone' ,
									email='$email' , 
									dateini='$dateini' , 
									datelast='$datelast' 
								WHERE dni='$originaldni'"; 
		//Ejecuto la sentencia 
	$rs = mysqli_query($dbh, $ssql); 
	if(!$rs){
		?>
		<p class="error">Error al modificar cliente</p>
		<?	
	}else{
		?>
		<p class="correcto">Cliente modificado correctamente</p>
		<?
	}
	mysqli_close($dbh);
	}else{
   		foreach ($errores as $error): ?>
        <?php echo "<p class='error'> $error </p>";
      	endforeach;
	}
	
	echo "<input class='boton' type='button' value='Cerrar' onclick='window.opener.location.reload(); window.close();'>";

?> 

</div>

</body>
</html>
