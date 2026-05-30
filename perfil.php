<?php
session_start();
include 'conexiones.php'; // Asegúrate de que tu archivo de conexión se llama así

// Si no hay sesión iniciada, lo mandamos al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtenemos el correo o ID del usuario guardado en la sesión
$correo_sesion = $_SESSION['usuario'];

// Consultamos los datos actuales del cliente en la base de datos
$query = "SELECT * FROM usuarios WHERE correo = '$correo_sesion'";
$resultado = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($resultado);

// Mensaje de éxito o error
$mensaje = "";

// Lógica para actualizar los datos cuando el cliente presiona "GUARDAR CAMBIOS"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nuevo_correo = $_POST['correo'];
    $password = $_POST['password'];
    $id = $usuario['id'];

    if (!empty($password)) {
        // Si escribió una contraseña, la encriptamos antes de guardarla
        $password_encriptada = password_hash($password, PASSWORD_BCRYPT);
        $update_query = "UPDATE usuarios SET nombre='$nombre', correo='$nuevo_correo', password='$password_encriptada' WHERE id=$id";
    } else {
        // Si no escribió contraseña, la dejamos intacta
        $update_query = "UPDATE usuarios SET nombre='$nombre', correo='$nuevo_correo' WHERE id=$id";
    }

    if (mysqli_query($conexion, $update_query)) {
        // Actualizamos la sesión por si cambió el correo
        $_SESSION['usuario'] = $nuevo_correo;
        $mensaje = "<p style='color: #daff3c; font-weight: bold; text-align: center;'>¡Perfil actualizado con éxito!</p>";
        
        // Volvemos a consultar para mostrar los datos nuevos en los campos
        $query = "SELECT * FROM usuarios WHERE correo = '$nuevo_correo'";
        $resultado = mysqli_query($conexion, $query);
        $usuario = mysqli_fetch_assoc($resultado);
    } else {
        $mensaje = "<p style='color: #ff0055; font-weight: bold; text-align: center;'>Error al actualizar el perfil.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - El Nido</title>
</head>
<body style="background-color: #0b0b0b; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;">

    <div style="background: #111111; border: 2px solid #ccff00; border-radius: 12px; padding: 30px; width: 100%; max-width: 450px; box-shadow: 0 0 15px rgba(204, 255, 0, 0.2); text-align: center; box-sizing: border-box;">
        
        <h2 style="color: #ccff00; font-size: 28px; margin-top: 0; margin-bottom: 20px; letter-spacing: 1px; text-transform: uppercase;">Mi Perfil</h2>
        
        <?php echo $mensaje; ?>

        <form action="perfil.php" method="POST">
            
            <label style="color: white; margin-top: 15px; display: block; text-align: left; font-size: 16px;">Nombre Completo:</label>
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required style="width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 15px; border: 1px solid #ccff00; background: #1a1a1a; color: white; border-radius: 8px; box-sizing: border-box; font-size: 15px;">

            <label style="color: white; margin-top: 15px; display: block; text-align: left; font-size: 16px;">Correo Electrónico:</label>
            <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required style="width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 15px; border: 1px solid #ccff00; background: #1a1a1a; color: white; border-radius: 8px; box-sizing: border-box; font-size: 15px;">

            <label style="color: white; margin-top: 15px; display: block; text-align: left; font-size: 16px;">Cambiar Contraseña (dejar vacío para mantener la actual):</label>
            <input type="password" name="password" placeholder="Escribe tu nueva contraseña" style="width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 25px; border: 1px solid #ccff00; background: #1a1a1a; color: white; border-radius: 8px; box-sizing: border-box; font-size: 15px;">

            <button type="submit" style="width: 100%; background-color: #daff3c; color: black; border: none; padding: 14px; font-weight: bold; font-size: 16px; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: 0.3s; box-shadow: 0 0 10px rgba(218, 255, 60, 0.4);">
                Guardar Cambios
            </button>

        </form>

        <div style="margin-top: 20px;">
            <a href="index.php" style="color: #888; text-decoration: none; font-size: 14px; transition: 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#888'">
                ← Volver al Menú
            </a>
        </div>

    </div>

</body>
</html>