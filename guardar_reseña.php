<?php
session_start();
include 'conexiones.php'; // Tu archivo de conexión

// Si el usuario no está logueado, no lo dejamos hacer nada
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Agarramos los datos que mandó el formulario
    $nombre = $_POST['nombre'];
    $mensaje = $_POST['mensaje'];
    
    // Aquí hacemos el INSERT para guardarlo en tu tabla de la base de datos
    // Nota: Asegúrate de que tu tabla se llame 'resenas' o cámbialo por el nombre real
    $query = "INSERT INTO resenas (nombre, mensaje) VALUES ('$nombre', '$mensaje')";
    
    if (mysqli_query($conexion, $query)) {
        // Si se guardó con éxito, lo regresamos a la página principal donde estaba el formulario
        header("Location: index.php?status=success"); 
        exit();
    } else {
        echo "Error al guardar la reseña: " . mysqli_error($conexion);
    }
}
?>