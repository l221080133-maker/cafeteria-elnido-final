<?php
// Habilitar errores por si pasa algo raro
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión usando getenv() que es compatible al 100% con Railway
$hostname = getenv('MYSQLHOST');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$database = getenv('MYSQLDATABASE');
$port     = getenv('MYSQLPORT');

// Intentar realizar la conexión a la base de datos
$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("<h2 style='color:red; text-align:center;'>Error de conexión a la Base de Datos: " . mysqli_connect_error() . "</h2>");
}
?>