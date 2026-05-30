<?php
include("conexiones.php");
session_start();

// SI LE DIO AL BOTÓN DE REGISTRARME
if (isset($_POST['registrar_nuevo'])) {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    // Insertamos el nuevo usuario en la tabla 'usuarios'
    $consulta = "INSERT INTO usuarios(nombre, correo, password) VALUES ('$nombre', '$correo', '$password')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        // Al registrarse con éxito, le asignamos la sesión automáticamente
        $_SESSION['usuario'] = $correo;
        echo "<script>alert('¡Registro exitoso! Bienvenido al Nido.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar tu cuenta'); window.location='login.php';</script>";
    }
}

// SI LE DIO AL BOTÓN DE INICIAR SESIÓN
if (isset($_POST['ingresar'])) {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    // Buscamos si el correo y la contraseña coinciden
    $consulta = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        // Si existe, extraemos sus datos y activamos las variables de sesión
        $fila_usuario = mysqli_fetch_assoc($resultado); 
        $_SESSION['usuario'] = $correo;
        $_SESSION['rol'] = $fila_usuario['rol']; // Con esto la página ya sabe que eres admin
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '¡BIENVENIDO AL NIDO!',
            text: 'Inicio de sesión correcto',
            icon: 'success',
            background: '#1a1a1a',
            color: '#fff',
            confirmButtonColor: '#ff0055',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'index.php';
        });
    });
</script>
<?php
    } else {
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '¡ERROR MACABÉLICO!',
            text: 'Correo o contraseña incorrectos',
            icon: 'error',
            background: '#1a1a1a',
            color: '#fff',
            confirmButtonColor: '#ff4444'
        }).then(() => {
            window.location.href = 'login.php';
        });
    });
</script>
<?php
    }
}
?>