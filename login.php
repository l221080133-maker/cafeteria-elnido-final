<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anderxito - Acceso</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #111;
            border: 2px solid var(--amarillo-neon);
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px var(--amarillo-neon);
        }
        .login-container h2 {
            color: #fff;
            margin-bottom: 20px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #222;
            border: 1px solid #444;
            color: #fff;
            border-radius: 5px;
        }
        .login-container input:focus {
            border-color: var(--amarillo-neon);
            outline: none;
        }
        .btn-form {
            width: 100%;
            padding: 11px;
            margin-top: 15px;
            background: var(--amarillo-neon);
            color: #000;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-form:hover {
            background: #fff;
            box-shadow: 0 0 10px #fff;
        }
        .btn-regresar {
            display: inline-block;
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-regresar:hover {
            color: var(--amarillo-neon);
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>ACCESO AL NIDO</h2>
    <form action="procesar_usuario.php" method="POST">
        <input type="text" name="nombre" placeholder="Tu Nombre (Solo para registrarse)">
        <input type="email" name="correo" placeholder="Tu Correo Electrónico" required>
        <input type="password" name="password" placeholder="Tu Contraseña" required>
        
        <button type="submit" name="ingresar" class="btn-form">INICIAR SESIÓN</button>
       <a href="registrar.php" class="btn-form" style="text-decoration: none; display: inline-block; text-align: center; background-color: #222; color: #fff; margin-top: 10px; width: 100%; box-sizing: border-box; padding: 11px;">REGISTRARSE</a>
    </form>
    <a href="index.php" class="btn-regresar">⬅ Volver a la Cafetería</a>
</div>

</body>
</html>