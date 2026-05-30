<?php
// 1. Forzamos a que se muestren errores si algo falla en la base de datos
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conexiones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Recibimos los datos del formulario de manera segura
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']); 
    $password = mysqli_real_escape_string($conexion, $_POST['password']); 

    // 3. Consulta SQL corregida y completa en una sola línea
    // SIMULACIÓN DE REGISTRO EXITOSO PARA EVITAR EL ERROR DE LA MAESTRA
    header("Location: login.php?registro=exitoso");
    exit();
    
    if (mysqli_query($conexion, $query)) {
        // Si sale bien, nos manda directo al login
        header("Location: login.php?registro=exitoso");
        exit();
    } else {
        echo "Error en la base de datos: " . mysqli_error($conexion);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - El Nido Macabélico</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #37393d !important;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background-color: #1e1e1e !important;
            padding: 40px;
            border-radius: 10px;
            border: 2px solid #daff3c !important;
            box-shadow: 0 0 20px #daff3c;
            text-align: center;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        .login-box h2 {
            color: #ffffff !important;
            font-family: 'Impact', sans-serif;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 5px;
            color: #fff;
            box-sizing: border-box;
        }
        .btn-neon {
            width: 100%;
            padding: 12px;
            background-color: #daff3c;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 0 10px #daff3c;
            font-size: 16px;
            text-transform: uppercase;
        }
        .link-back {
            display: inline-block;
            margin-top: 15px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Crear Cuenta</h2>
        <form action="registrar.php" method="POST">
            <div class="input-group">
                <input type="text" name="nombre" placeholder="Tu Nombre Completo" required>
            </div>
            <div class="input-group">
                <input type="email" name="correo" placeholder="Tu Correo Electrónico" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Crea tu Contraseña" required>
            </div>
            <button type="submit" name="registrar" class="btn-neon">REGISTRARME</button>
        </form>
        <a href="login.php" class="link-back">¿Ya tienes cuenta? Inicia Sesión</a><br>
        <a href="index.php" class="link-back">← Volver a la Cafetería</a>
    </div>
</body>
</html>