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
	
	$tipo = $_POST['tipo'];
	
	if ($tipo=="registrar"){	
		?>	
		<form method="post" action="registrarCliente.php">
        <table border=0>
        <tr><td>DNI (*sin letra) </td><td><input type="number" name="dni" size="9" maxlength="9"> </td></tr>
        <tr><td>Nombre y Apellidos </td><td><input type="text" name="name" maxlength="50"> </td></tr>
        <tr><td>Móvil:</td><td><input type="number" name="phone" size="8" maxlength="9"> </td></tr>
        <tr><td>Correo electrónico </td><td><input type="text" name="email" maxlength="50"> </td></tr>
        <tr><td>Local a asignar </td><td> <? echo $_POST['local']; ?><input type="hidden" name="local" value="<? echo $_POST['local']; ?>" size="1" maxlength="1"> </td></tr>
        <tr><td>Fecha de inicio <input type="date" name="dateini">
        </td><td>Fecha de fin <input type="date" name="datelast"></td></tr>
        <tr><td><input class="boton" type="submit" value="Registrar cliente"/></td><td>
        <input class="boton" type="reset" value="Borrar"></td></tr>
        </table>
        </form>
        <?
	}else{
		if ($tipo=="editar"){
			?>	
            <form method="post" action="editarCliente.php">
            <table border=0>
            <tr><td>DNI (*sin letra) </td><td><input type="number" name="dni" value="<? echo $_POST['dni']; ?>" size="9" maxlength="9"> </td></tr>
            <tr><td>Nombre y Apellidos </td><td><input type="text" name="name" value="<? echo $_POST['name']; ?>" maxlength="50"> </td></tr>
            <tr><td>Móvil </td><td><input type="number" name="phone" value="<? echo $_POST['phone']; ?>" size="8" maxlength="9"> </td></tr>
            <tr><td>Correo electronico </td><td><input type="text" name="email" value="<? echo $_POST['email']; ?>" maxlength="50"> </td></tr>
            <tr><td>Local a asignar </td><td> <? echo $_POST['local']; ?></td></tr>
            <tr><td>Fecha de inicio <input type="date" name="dateini" value="<? echo $_POST['dateini']; ?>"></td>
            <td>Fecha de fin <input type="date" name="datelast" value="<? echo $_POST['datelast']; ?>"></td></tr>
            <tr><td><input class="boton" type="submit" value="Editar cliente"/></td></tr>
            <input class="boton" type="hidden" name="originaldni" value="<? echo $_POST['dni']; ?>"/>
            </table>
            </form>
            <?
		}else{
			if ($tipo=="terminar"){
				?>	
                <form method="post" action="terminarCliente.php">
                <table border=0>
                <tr><td>¿Esta seguro de terminar el contrato de <? echo $_POST['name']; ?>? </td></tr>
                <tr><td>Guardar este contrato en historial</td><td><input type="checkbox" name="guardar" value="si" checked="checked"/></td></tr>
                <tr><td><input class="boton" type="submit" value="Terminar cliente"/></td></tr>
                <input type="hidden" name="dni" value="<? echo $_POST['dni']; ?>" size="9" maxlength="9"> 
				</table>                
                </form>
                <?			
				}else{
				header ("index.php?errorusuario=si");
			}
		}
	}
	
	
?>
</div>

</body>
</html>
