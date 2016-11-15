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
	
	if (isset($_POST['id_peticion']) AND isset($_POST['local'])){
		eliminarPeticion($_POST['id_peticion']);
	}
	  
	$dni = ltrim($_POST['dni'], '0');
	$pass = generaPass();
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$local = $_POST['local'];
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
   $opciones_local = array('options' => array('min_range' => 1,'max_range' => 5));
   	if (!validarEntero($local, $opciones_local)) {
      $errores[] = 'El campo local es incorrecto.';
   	}
	/************************/
	if (!$errores){
		include("dbconnect.php");
		$ssql = "INSERT INTO usuario VALUES ('$dni',MD5($pass),'','$name','$phone','$email','$local','$dateini','$datelast','','')"; 
		//Ejecuto la sentencia 
		$rs = mysqli_query($dbh, $ssql); 
		if(!$rs){
			?><p class="error">Error al insertar cliente</p><?	
		}else{
			?><p class="correcto">Cliente insertado correctamente</p><?
			enviarCorreo($dni, $pass, $local, $dateini, $datelast, $email);
		}
		mysqli_close($dbh);
	}else{
   		foreach ($errores as $error): ?>
        <?php echo "<p class='error'> $error </p>";
      	endforeach; 
	}
	
	echo "<input class='boton' type='button' value='Cerrar' onclick='window.opener.location.reload(); window.close();'>";

	
	
function generaPass(){
    //Se define una cadena de caractares.
    $cadena = "1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=6;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la 					posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}


///////////////////////////////////////////////////////////////////

 function eliminarPeticion($id){
	 include("dbconnect.php");

	$sql="DELETE FROM peticion WHERE id_peticion='$id'";
	$result= mysqli_query($dbh, $sql) or die(mysql_error());
	mysqli_close($dbh);
 }

///////////////////////////////////////////////////////////////////

 function enviarCorreo($dni, $pass, $local, $fini, $ffin, $email_to){
	 
	$email_subject = "[Macroacusti] Información de registro en local de ensayo  ";
 
	$email_message = "¡Bienvenido! Aquí se muestra los detalles de acceso al rincón personal:\n\n";
	$email_message .= "   Usuario: " . $dni . "\n";
	$email_message .= "   Contraseña: " . $pass . "\n";
	$email_message .= "   URL: sensoresdepresencia.hol.es \n\n";
	$email_message .= "Detalle del contrato: \n";
	$email_message .= "   Local: " . $local . "\n";
	$email_message .= "   Fecha de inicio: " . $fini . "\n";
	$email_message .= "   Fecha final: " . $ffin . "\n";

	
	$email_from = "hectorgarciamiguel@gmail.com";
	// Ahora se envía el e-mail usando la función mail() de PHP
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers); 
	 
	 
 }



?> 

    </div>

</body>
</html>
