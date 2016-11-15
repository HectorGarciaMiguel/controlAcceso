
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="estilo.css">
<body>
<div class="celda">


<?
ini_set("session.use_only_cookies","1"); 
ini_set("session.use_trans_sid","0");

if(!isset($_POST['dni'])){

	echo "<p class='error'> El campo dni es incorrecto. </p>";
	
}else{	
	include("dbconnect.php");
	$dni = ltrim($_POST['dni'], '0');
	$ip = $_SERVER['REMOTE_ADDR'];
	
	
	require_once 'validar.php';
	$errores = array();

	$opciones_dni = array('options' => array('min_range' => 1,'max_range' => 999999999));
	if (!validarEntero($dni, $opciones_dni)) {
		echo "<p class='error'> El campo dni es incorrecto. </p>";
	}else{
	
		//Clean the old request
		$ssqlreset0="DELETE FROM resetpass WHERE date_resetpass < DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND date_resetpass > DATE_ADD(CURDATE(), INTERVAL -100 DAY)";
		$rsreset0=mysqli_query($dbh, $ssqlreset0);
		
		//Check max reset of a ip
		$ssqlreset = "SELECT * FROM resetpass WHERE ip='$ip' AND date_resetpass > DATE_ADD(CURDATE(), INTERVAL -1 DAY)"; 
		$rsreset = mysqli_query($dbh, $ssqlreset);
		if (mysqli_num_rows($rsreset)==1){
				
				$rowreset=mysqli_fetch_array($rsreset);
				if ($rowreset['nintentos']<3){
					$id_resetpass = $rowreset['id_resetpass'];
					$nintentos = $rowreset['nintentos'] + 1 ;
					$ssqlreset2 = "UPDATE resetpass SET nintentos='$nintentos', date_resetpass=CURDATE() WHERE id_resetpass='$id_resetpass'";
					$rsreset2 = mysqli_query($dbh, $ssqlreset2);
				
				
					$ssqlreset3 = "SELECT * FROM usuario WHERE dni='$dni'"; 
					$rsreset3 = mysqli_query($dbh, $ssqlreset3);
					
					if (mysqli_num_rows($rsreset3)==1){
						$rowreset3=mysqli_fetch_array($rsreset3);
						$email_to = $rowreset3['email'];
						// Update the pass
						$pass = generaPass();
						$ssqlreset4 = "UPDATE usuario SET pass=MD5($pass) WHERE dni='$dni'"; 
						$rsreset4 = mysqli_query($dbh, $ssqlreset4);
						// Send a mail with a new pass
						sendMail($dni, $pass, $email_to);
							
						//Success message
						echo "<p class='correcto'> La nueva contraseña se ha enviado a su correo electrónico. </p>"; 
					}else{
						echo "<p class='error'> El usuario no existe. </p>";
					}
					mysqli_free_result($rsreset3); 
					mysqli_free_result($rsreset); 
					
				}else{ // more than 3 attempts  
					echo "<p class='error'> Demasiadas peticiones de cambio de contraseña por hoy. </p>";
					mysqli_free_result($rsreset); 
				}		
		}else{ // its a new reset pass request
			$ssqlreset3="INSERT INTO resetpass VALUES ('','$ip',CURDATE(),'1')";
			$rsreset3=mysqli_query($dbh, $ssqlreset3);
			
			
			$ssqlreset3 = "SELECT * FROM usuario WHERE dni='$dni'"; 
			$rsreset3 = mysqli_query($dbh, $ssqlreset3);
					
			if (mysqli_num_rows($rsreset3)==1){
				$rowreset3=mysqli_fetch_array($rsreset3);
				$email_to = $rowreset3['email'];
				// Update the pass
				$pass = generaPass();
				$ssqlreset4 = "UPDATE usuario SET pass=MD5($pass) WHERE dni='$dni'";
				$ssqlreset4 = mysqli_query($dbh, $ssqlreset4);
				// Send a mail with a new pass
				sendMail($dni, $pass, $email_to);
			
				//Success message
				echo "<p class='correcto'> La nueva contraseña se ha enviado a su correo electrónico. </p>"; 
			}else{
				echo "<p class='error'> El usuario no existe. </p>";
			}	
		}
	}
}

mysqli_close($dbh); 
	
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
	
	
function sendMail($user, $pass, $email_to){
	// Send a mail with a new pass
	$email_subject = "[Macroacusti] Nueva contraseña  ";
	$email_message = "¡Hola! Se ha procedido a resetear la contraseña:\n\n";
	$email_message .= "   Usuario: " . $user . "\n";
	$email_message .= "   Nueva contraseña: " . $pass . "\n";
	$email_message .= "   URL: sensoresdepresencia.hol.es \n\n";
	$email_from = "hectorgarciamiguel@gmail.com";
	// send mail mail() de PHP
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);
}
?>
</div>

</body>
</html>
