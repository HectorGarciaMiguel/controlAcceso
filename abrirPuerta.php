<? include ("seguridad.php");

	if (!isset($_SESSION["admin"]) || !isset($_SESSION["user"])) {
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

<div class="celda">

		<form method="post" action="********************.php">
        <input type="number" name="codigo"> 
        <input class="boton" type="submit" value="Confirmar y abrir entrada" />
        </form>

</div>



</body>
</html>