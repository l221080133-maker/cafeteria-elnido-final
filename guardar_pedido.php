<?php
include("conexiones.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "error_sesion";
    exit();
}

$usuario = $_SESSION['usuario'];
$productos = $_POST['productos'];
$total = $_POST['total']; 

// Recibimos la cantidad exacta que nos manda el carrito
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1; 

// Guardamos en tu base de datos
$consulta = "INSERT INTO pedidos (usuario, productos, total, cantidad) VALUES ('$usuario', '$productos', '$total', '$cantidad')";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    echo "pedido_exitoso";
} else {
    echo "error_bd";
}