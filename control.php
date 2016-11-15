<? 	
ini_set("session.use_only_cookies","1"); 
ini_set("session.use_trans_sid","0");

include("dbconnect.php");
$user = ltrim($_POST['username'], '0'); 
$pass = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];

//Clean the old access
$ssqlacceso0="DELETE FROM accesoweb WHERE fecha_acceso < DATE_ADD(NOW(), INTERVAL -1 DAY) AND fecha_acceso > DATE_ADD(NOW(), INTERVAL -100 DAY)";
$rsacceso0=mysqli_query($dbh, $ssqlacceso0);

//Execute SQL 
$ssql = "SELECT * FROM usuario WHERE dni='$user' AND pass=MD5($pass)"; 
$rs = mysqli_query($dbh, $ssql); 
 
if (mysqli_num_rows($rs)==1){ 
	$row=mysqli_fetch_array($rs);
	
	$ssql2 = "SELECT * FROM usuario WHERE dni='$user' AND pass=MD5($pass) AND dateini<=CURDATE() AND datelast>=CURDATE()"; 
	$rs2 = mysqli_query($dbh, $ssql2);
	if (mysqli_num_rows($rs2)==1){
		$row2=mysqli_fetch_array($rs2);
 
 		session_name("loginUsuario"); 
		session_start(); 
		session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0);
		$_SESSION["autentificado"] = "true";
		$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s"); 
		$_SESSION["dni"] = $user;
			mysqli_free_result($rs); 
			mysqli_free_result($rs2); 
			mysqli_close($dbh);
			
		if ($row2['permits']==1){
			$_SESSION["admin"] = 1;
			
			echo '<script type="text/javascript">
			window.location.assign("aplicacion_admin.php");
			</script>';
		}else{
			$_SESSION["user"] = 1;
			
			echo '<script type="text/javascript">
			window.location.assign("aplicacion_usuario.php");
			</script>';
		}
				
	}else{
		mysqli_free_result($rs); 
		mysqli_free_result($rs2); 
		mysqli_close($dbh); 
		//si no existe le mando otra vez a la portada 
   		header("Location: index.php?errorcontrato=1");
	}
}else{ 
	//Check attempts
	$ssqlacceso = "SELECT * FROM accesoweb WHERE ip='$ip' AND fecha_acceso > DATE_ADD(NOW(), INTERVAL -15 MINUTE)"; 
	$rsacceso = mysqli_query($dbh, $ssqlacceso);
	
	if (mysqli_num_rows($rsacceso)==1){
		$rowacceso=mysqli_fetch_array($rsacceso);
		if ($rowacceso['nintentos']<3){ // Inc attempts
			$id_accesoweb = $rowacceso['id_accesoweb'];
			$nintentos = $rowacceso['nintentos'] + 1 ;
			$ssqlacceso2 = "UPDATE accesoweb SET nintentos='$nintentos', fecha_acceso=NOW() WHERE id_accesoweb='$id_accesoweb'";
			$rsacceso2 = mysqli_query($dbh, $ssqlacceso2);
			
		}else{ // more than 3 attempts 
			mysqli_free_result($rs); 
			mysqli_free_result($rowacceso); 
			mysqli_free_result($rowacceso0); 
			mysqli_close($dbh); 
			header("Location: index.php?maxaccesos=1");
			exit();
		}		
	}else{
		$ssqlacceso3="INSERT INTO accesoweb VALUES ('','$ip',NOW(),'1')";
		$rsacceso3=mysqli_query($dbh, $ssqlacceso3);
	}
	mysqli_free_result($rs); 
	mysqli_free_result($rowacceso); 
	mysqli_free_result($rowacceso2);
	mysqli_free_result($rowacceso3);  
	mysqli_close($dbh); 
   	 
   	header("Location: index.php?errorusuario=1");
} 

?>