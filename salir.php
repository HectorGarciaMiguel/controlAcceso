<?
session_name("loginUsuario"); 
session_start();
session_unset($_SESSION["admin"]);
session_unset($_SESSION["user"]); 
session_unset($_SESSION["ultimoAcceso"]); 
session_unset($_SESSION["autentificado"]); 
session_unset($_SESSION["dni"]); 
session_destroy(); 
header("Location: index.php");
?>
