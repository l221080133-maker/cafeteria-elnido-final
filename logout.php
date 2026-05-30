<?php
session_start();
session_destroy(); // Borra la sesión del usuario logeado
header("Location: index.php"); // Lo manda de regreso a la página principal
exit();
?>