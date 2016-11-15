<html> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="estilo.css">
<head> 
<title>Macroacusti - Acceso a locales de ensayo</title> 
</head> 
<body> 

<div class="titulo">
	<h2 align="center">Acceso a locales de ensayo 
    <a href="http://www.macroacusti.es/"><img src="/recursos/logo.png" width="200px" align="right" ></a></h2>
    <p align="right">Contacto: <a href="mailto:info@macroacusti33.com">info@macroacusti33.com</a>
</div>


<div id="centrado">
<ul><li>
	<div class="celda">
    	<form action="control.php" method="POST"> 
    	<table align="center" cellspacing="2" cellpadding="2" border="0"> 
    	<tr> 
    	<td colspan="2" align="center">
    		<? if ($_GET["errorusuario"]=="1"){ ?> 
        		<p class="error">Datos incorrectos</p>
    		<? }else{ 
         		if ($_GET["errorcontrato"]=="1"){ ?> 
            		<p class="error">Cliente fuera de contrato</p>
        		<? }else{ 
           	 		if ($_GET["maxaccesos"]=="1"){ ?> 
                		<p class="error">Máximo de accesos erróneos. Espere 15 minutos</p>
           			 <? }else{ ?>
                			Introduce tu clave de acceso 
    	<? } } }?> </td> </tr> 
    	<tr> <td align="right">DNI (*sin letra)		</td> <td><input type="number" name="username" maxlength="9"></td> </tr> 
    	<tr> <td align="right">Contraseña			</td> <td><input type="password" name="password" maxlength="32"></td> </tr> 
    	<tr> <td colspan="2" align="center"><input class="boton" type="Submit" value="Entrar"></td> </tr> 
    	</table> 
    	</form>

		<? if ($_GET["maxpet"]=="1"){ ?> 
            <p class="error">Demasiadas peticiones enviadas</p>
        <? } ?>
        
        <? if ($_GET["resetpass"]=="1"){ ?> 
            <p align="center"><a href="index.php">-Cerrar-</a></p>
            <form method="post" action="resetearContrasena.php" target="popup"
            onsubmit="window.open('', 'popup', 'width = 520, height = 210, top = 200, left = 300')">
                <table border=0 align="center">
                <tr><td align="justify">DNI (*sin letra) </td><td><input type="number" name="dni" maxlength="9"> </td></tr>
                <tr><td colspan="2" align="center"><input class="boton" type="submit" value="Resetear Contraseña"/></td></tr>
                </table>
                </form>
        <? }else{ ?>
            <p align="center"><a href="index.php?resetpass=1">-Olvidó su contraseña-</a></p>
        <? } ?>
	</div>
</li><li>
	<div class="celda">

		<? if ($_GET["peticionregistro"]=="1"){ ?> 
            <p align="center"><a href="index.php">-Cerrar-</a></p>
            <form method="post" action="peticionRegistro.php" target="popup"
            onsubmit="window.open('', 'popup', 'width = 520, height = 210, top = 200, left = 300')">
                <table border=0 align="center">
                <tr><td align="justify">DNI (*sin letra) </td><td><input type="number" name="dni" maxlength="9"> </td></tr>
                <tr><td align="justify">Nombre y Apellidos </td><td><input type="text" name="name" maxlength="50"> </td></tr>
                <tr><td align="justify">Móvil </td><td><input type="number" name="phone" maxlength="9"> </td></tr>
                <tr><td align="justify">Correo electrónico </td><td><input type="text" name="email" maxlength="50"> </td></tr>
                <tr><td>Fecha de inicio <input type="date" name="dateini">
                </td><td>Fecha de fin <input type="date" name="datelast"></td></tr>
                <tr><td><input class="boton" type="submit" value="Enviar petición"/></td><td>
                <input class="boton" type="reset" value="Borrar"></td></tr>
                </table>
                </form>
        <? }else{ ?>
            <p align="center"><a href="index.php?peticionregistro=1">-Petición registro-</a></p>
        <? } ?>
    
	</div>
    </li></ul>
</div>

</body> 
</html>

