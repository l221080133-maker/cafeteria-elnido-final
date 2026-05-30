<?php
session_start();
include("conexiones.php"); // Tu conexión única

// 🛡️ Seguridad: Si no es admin, no entra
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 🔍 Buscar los datos del usuario que seleccionaste
if (isset($_GET['id'])) {
    $id_editar = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id = '$id_editar'";
    $resultado = mysqli_query($conexion, $query);
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario) {
        echo "<script>alert('Usuario no encontrado'); window.location='admin.php';</script>";
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Panel Arsenal</title>
    <style>
        body { background-color: #000; color: #fff; font-family: sans-serif; padding: 40px; }
        .contenedor { max-width: 400px; margin: 0 auto; background: #111; padding: 30px; border: 2px solid #daff3c; border-radius: 8px; }
        .form-editar { display: flex; flex-direction: column; gap: 15px; }
        input, select { padding: 10px; background: #222; border: 1px solid #daff3c; color: white; border-radius: 4px; }
        button { padding: 12px; background: #daff3c; color: black; font-weight: bold; cursor: pointer; border: none; border-radius: 4px; }
        button:hover { background: #ccff00; }
        .btn-cancelar { color: #aaa; text-align: center; margin-top: 10px; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

    <div class="contenedor">
        <h2 style="text-align: center; color: #daff3c; margin-top: 0;">EDITAR USUARIO</h2>

        <form action="admin.php" method="POST" class="form-editar">
            
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id']; ?>">

            <label>Nombre Completo:</label>
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

            <label>Correo Electrónico:</label>
            <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required>

           <label style="color: white; margin-top: 15px; display: block; text-align: left; font-size: 16px;">Rol del Sistema:</label>
    <select name="rol" style="width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 15px; border: 1px solid #ccff00; background: #1a1a1a; color: white; border-radius: 8px; box-sizing: border-box;">
        <option value="cliente" <?php if($usuario['rol'] == 'cliente') echo 'selected'; ?>>Cliente</option>
        <option value="admin" <?php if($usuario['rol'] == 'admin') echo 'selected'; ?>>Administrador</option>
    </select>

    <label style="color: white; margin-top: 15px; display: block; text-align: left; font-size: 16px;">Nueva Contraseña (dejar vacío para mantener la actual):</label>
    <input type="password" name="password" placeholder="Escribe la nueva contraseña aquí" style="width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 20px; border: 1px solid #ccff00; background: #1a1a1a; color: white; border-radius: 8px; box-sizing: border-box;">
            <button type="submit" name="actualizar_usuario">GUARDAR CAMBIOS</button>
            <a href="admin.php" class="btn-cancelar">Cancelar y Volver</a>
        </form>
    </div>

</body>
</html>