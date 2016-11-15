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
	
	//Limitar peticiones por ip

	require_once 'validar.php';
	$errores = array();
	 
	$ip=$_SERVER['REMOTE_ADDR'];	  
	$dni = ltrim($_POST['dni'], '0');
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
   //Valida que el campo email sea correcto.
   if (!validaEmail($email)) {
      $errores[] = 'El campo email es incorrecto.';
   }
	/************************/
	if (!$errores){
		include("dbconnect.php");
		$ssql = "SELECT count(*) as total FROM peticion WHERE ip='$ip'"; 
		$rs = mysqli_query($dbh, $ssql);
		$data=mysqli_fetch_array($rs);
		if ($data['total']>2){
			?> <p class="error">Demasiadas peticiones realizadas</p> <?
		}else{
			$ssql2 = "SELECT count(*) as total FROM peticion WHERE dni='$dni'"; 
			$rs2 = mysqli_query($dbh, $ssql2);
			$data2=mysqli_fetch_array($rs2);
			if ($data2['total']>2){
				?> <p class="error">Demasiadas peticiones realizadas por parte de la misma persona</p> <?
			}else{
					$ahora = new DateTime();
    				$ahora->setTimestamp(time()+3600); 
    				$now = $ahora->format('Y-m-d H:i:s');
				$ssql3 = "INSERT INTO peticion VALUES ('','$now','$ip','$dni','$name','$phone','$email','$dateini','$datelast')"; 
				//Ejecuto la sentencia 
				$rs3 = mysqli_query($dbh, $ssql3); 
				if(!$rs3){
					?> <p class="error">Error al enviar la petición</p> <?	
				}else{
					?> <p class="correcto">Petición enviada correctamente, esté atento a su correo</p> <?
					}
			}
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
