<?php
// Configuración de la conexión a Railway de forma pública
$conexion = mysqli_connect(
    "zephyr.proxy.rlwy.net", 
    "root", 
    "RehvqWewbujbTGaROZZbZzNmpmZAuKCb", 
    "railway", 
    59736
);

if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
?>