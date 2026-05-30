<?php
$hostname = $_ENV['MYSQLHOST'];
$username = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];
$database = $_ENV['MYSQLDATABASE'];
$port     = $_ENV['MYSQLPORT'];

$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>