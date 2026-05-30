<?php
session_start();
include("conexiones.php"); // 🔌 Conexión única al principio
// 🔄 MOTOR C: ACTUALIZAR USUARIO EXISTENTE
    if (isset($_POST['actualizar_usuario'])) {
        $id_usuario = $_POST['id_usuario'];
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $rol = $_POST['rol']; 

        // Query limpio para actualizar los datos en tu tabla usuarios
        $query_editar = "UPDATE usuarios SET nombre='$nombre', correo='$correo', rol='$rol' WHERE id='$id_usuario'";
        $ejecutar_editar = mysqli_query($conexion, $query_editar);

        if ($ejecutar_editar) {
            echo "<script>alert('¡Usuario actualizado con éxito!'); window.location='admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error al intentar actualizar el usuario.');</script>";
        }
    }
// 🛡️ Seguridad: Si no es admin, para afuera
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 🔥 MOTOR BORRADOR: Si detecta un ID para eliminar en la URL
if (isset($_GET['eliminar_id'])) {
    $id_a_borrar = $_GET['eliminar_id'];
    
    // Ejecutamos la orden de eliminación
    $query_borrar = "DELETE FROM usuarios WHERE id = '$id_a_borrar'";
    $ejecutar = mysqli_query($conexion, $query_borrar);
    
    if ($ejecutar) {
        // Refrescamos la pantalla al instante
        echo "<script>window.location='admin.php';</script>";
    }
}

// 🍔 MOTOR A: ELIMINAR PRODUCTO DEL MENÚ
    if (isset($_GET['eliminar_producto_id'])) {
        $prod_id = $_GET['eliminar_producto_id'];
        $query_borrar_prod = "DELETE FROM productos WHERE id = '$prod_id'";
        mysqli_query($conexion, $query_borrar_prod);
        echo "<script>window.location='admin.php';</script>";
    }

    // ➕ MOTOR B: AGREGAR NUEVO PRODUCTO AL MENÚ
    if (isset($_POST['agregar_producto'])) {
        $nombre = trim($_POST['nombre']);
        $precio = trim($_POST['precio']);
        
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        
        // Carpeta correcta: guarda las imágenes donde tu index las busca
        $carpeta_destino = "img/" . $nombre_imagen;
        
        if (move_uploaded_file($ruta_temporal, $carpeta_destino)) {
            // El SQL arreglado completo en una sola línea
            $query_agregar = "INSERT INTO productos (nombre, precio, imagen) VALUES ('$nombre', '$precio', '$nombre_imagen')";
            $ejecutar_agregar = mysqli_query($conexion, $query_agregar);
            
            if ($ejecutar_agregar) {
                echo "<script>alert('¡Café agregado al Arsenal con éxito!'); window.location='admin.php';</script>";
            } else {
                echo "<script>alert('Error de base de datos al insertar el producto.');</script>";
            }
        } else {
            echo "<script>alert('Error: No se pudo mover la imagen a la carpeta img/imagenes/.');</script>";
        }
    }
// 👤 Consulta 2: Traer los usuarios
$consulta_usuarios = "SELECT * FROM usuarios";
$resultado_usuarios = mysqli_query($conexion, $consulta_usuarios);

// ☕ NUEVA Consulta 3: ¡Traer tus productos y cafés!
$consulta_productos = "SELECT * FROM productos";
$resultado_productos = mysqli_query($conexion, $consulta_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anderxito - Dashboard de Control</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background-color: #1a1a1a; 
            color: #ffffff; 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
        }
        .dashboard-container { 
            padding: 40px; 
            text-align: center; 
        }
        .tabla-admin { 
            width: 85%; 
            margin: 30px auto; 
            border-collapse: collapse; 
            background: #000000; 
            color: #ffffff; 
        }
        .tabla-admin th, .tabla-admin td { 
            padding: 15px; 
            border: 2px solid #daff3c; 
            text-align: left; 
        }
        .tabla-admin th { 
            background: #daff3c; 
            color: #000000; 
            font-weight: bold; 
            text-transform: uppercase;
        }
        .tabla-admin tr:hover {
            background: #222222;
        }
        .btn-volver-nido { 
            display: inline-block; 
            width: 220px; 
            margin-top: 25px; 
            text-align: center; 
            background: #daff3c; 
            color: #000000; 
            padding: 12px; 
            text-decoration: none; 
            font-weight: bold; 
            border-radius: 5px; 
            text-transform: uppercase;
        }
        .btn-volver-nido:hover { 
            background: #ffffff; 
            color: #000000;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1 style="color: #daff3c; font-size: 38px; margin-bottom: 5px; font-weight: 900;">📋 CENTRAL DE CONTROL (COAPA)</h1>
    <p style="color: #aaaaaa; margin-bottom: 30px; font-size: 16px;">Visualización en tiempo real de los reportes y pedidos de la Base de Datos</p>

    <table class="tabla-admin">
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 30%;">JUGADOR (CLIENTE)</th>
                <th style="width: 60%;">REPORTE (MENSAJE / ESTRATEGIA)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Aquí mandamos a llamar a tu archivo existente para conectar con tu base de datos
            include("conexiones.php");
            
            if (!isset($conexion) || !$conexion) {
                echo "<tr><td colspan='3' style='text-align:center; color:#ff4d4d; font-weight:bold;'>⚠️ Error: No se pudo establecer la conexión a través de conexiones.php</td></tr>";
            } else {
                // Consultamos tu tabla de mensajes
                $sql = "SELECT * FROM mensajes ORDER BY id DESC";
                $resultado = mysqli_query($conexion, $sql);

                if($resultado && mysqli_num_rows($resultado) > 0) {
                    while($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td style='color: #daff3c; font-weight: bold;'>" . $fila['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['mensaje']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; color: #aaaaaa; padding: 30px;'>No hay registros o reportes guardados en el nido todavía.</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>


    <br><br>
<div style="padding: 20px; background: #111; color: #fff; border: 2px solid #daff3c; margin: 40px auto; max-width: 85%; border-radius: 8px; font-family: sans-serif; box-shadow: 0 0 15px rgba(218, 255, 60, 0.2);">
    <h2 style="color: #daff3c; text-shadow: 0 0 10px #daff3c; text-align: left; margin-bottom: 20px;">📋 PEDIDOS ENTRANTES A LA COCINA</h2>
    
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente (Correo)</th>
                <th>Productos</th>
                <th>Total Pagado</th>
                <th>Fecha / Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Usamos la variable $resultado que definiste en la línea 4
            while($fila_pedido = mysqli_fetch_array($resultado)) { 
            ?>
            <tr>
                <td style="color: #daff3c; font-weight: bold;"><?php echo $fila_pedido['id']; ?></td>
                <td><?php echo $fila_pedido['usuario']; ?></td>
                <td style="font-style: italic; color: #ccc;"><?php echo $fila_pedido['productos']; ?></td>
                <td style="color: #00ff88; font-weight: bold;">$<?php echo $fila_pedido['total']; ?></td>
                <td style="color: #888; font-size: 14px;"><?php echo $fila_pedido['fecha']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div style="border: 2px solid #ccff00; padding: 20px; border-radius: 10px; margin: 30px auto; max-width: 85%; background-color: #111; box-shadow: 0 0 15px rgba(204, 255, 0, 0.2);">
        <h2 style="color: #ccff00; text-shadow: 0 0 10px #ccff00; font-family: sans-serif; text-align: left; margin-bottom: 20px;">👤 CONTROL DE USUARIOS REGISTRADOS</h2>
        
        <table style="width: 100%; border-collapse: collapse; text-align: center; color: white; font-family: sans-serif;">
            <thead>
                <tr style="background-color: #ccff00; color: black; font-weight: bold; height: 40px;">
                    <td style="padding: 10px;">ID</td>
                    <td>NOMBRE</td>
                    <td>CORREO</td>
                    <td>ROL</td>
                    <td>ACCIONES</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Recorremos los usuarios de tu base de datos uno por uno
                while ($user = mysqli_fetch_assoc($resultado_usuarios)) { 
                ?>
                <tr style="border-bottom: 1px solid #333; height: 50px;">
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['nombre']; ?></td>
                    <td><?php echo $user['correo']; ?></td>
                    <td style="color: <?php echo ($user['rol'] == 'admin') ? '#ff0055' : '#00ffcc'; ?>; font-weight: bold;">
                        <?php echo strtoupper($user['rol']); ?>
        <td>
        <a href="editar_usuario.php?id=<?php echo $user['id']; ?>" style="background-color: #daff3c; color: black; padding: 6px 12px; text-decoration: none; font-weight: bold; border-radius: 5px; margin-right: 8px; display: inline-block;">✏️ Editar</a>
        <a href="admin.php?eliminar_id=<?php echo $user['id']; ?>" style="background-color: #ff0055; color: white; padding: 6px 12px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block; box-shadow: 0 0 8px #ff0055;">❌ Eliminar</a>
    </td>
        
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div style="border: 2px solid #ccff00; padding: 20px; border-radius: 10px; margin: 30px auto; max-width: 85%; background-color: #111; box-shadow: 0 0 15px rgba(204, 255, 0, 0.2); font-family: sans-serif; color: white;">
        
        <h2 style="color: #ccff00; text-shadow: 0 0 10px #ccff00; text-align: left; margin-bottom: 20px;">🍔 AGREGAR NUEVO CAFÉ O PRODUCTO</h2>
        
        <form action="admin.php" method="POST" enctype="multipart/form-data" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px dashed #333;">
            <input type="text" name="nombre" placeholder="Nombre del café" required style="background: #222; color: white; border: 1px solid #ccff00; padding: 10px; border-radius: 5px; flex: 1; min-width: 200px;">
            <input type="number" step="0.01" name="precio" placeholder="Precio ($)" required style="background: #222; color: white; border: 1px solid #ccff00; padding: 10px; border-radius: 5px; width: 120px;">
            <input type="file" name="imagen" accept="image/*" required style="color: white;">
            <button type="submit" name="agregar_producto" style="background-color: #ccff00; color: black; font-weight: bold; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; box-shadow: 0 0 8px #ccff00;">➕ Añadir Producto</button>
        </form>

        <h2 style="color: #ccff00; text-shadow: 0 0 10px #ccff00; text-align: left; margin-bottom: 20px;">☕ CAFÉS ACTUALES EN EL MENÚ</h2>
        
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background-color: #ccff00; color: black; font-weight: bold; height: 40px;">
                    <td style="padding: 10px;">ID</td>
                    <td>FOTO</td>
                    <td>PRODUCTO</td>
                    <td>PRECIO</td>
                    <td>ACCIONES</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($prod = mysqli_fetch_assoc($resultado_productos)) { ?>
                <tr style="border-bottom: 1px solid #333; height: 60px;">
                    <td><?php echo $prod['id']; ?></td>
                    <td>
                       <img src="img/<?php echo $prod['imagen']; ?>" alt="café" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; box-shadow: 0 0 5px rgba(218, 255, 60, 0.3);">
                    </td>
                    <td style="font-weight: bold;"><?php echo $prod['nombre']; ?></td>
                    <td style="color: #00ffcc; font-weight: bold;">$<?php echo number_format($prod['precio'], 2); ?></td>
                    <td>
                        <a href="admin.php?eliminar_producto_id=<?php echo $prod['id']; ?>" 
                           onclick="return confirm('¿Seguro que quieres sacar este café del menú?');"
                           style="background-color: #ff0055; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 0 8px #ff0055; display: inline-block;">
                           ❌ Eliminar
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="index.php" class="btn-volver-nido">⬅️ VOLVER AL NIDO</a>

</div>

</body>
</html>