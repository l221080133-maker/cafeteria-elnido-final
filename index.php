<?php
ini_set('display_errors', 1);
 error_reporting(E_ALL);
 session_start();
 include 'conexiones.php';

// Si tu login guarda el rol, lo jalamos. Si no hay sesión, por defecto es 'cliente'
$usuario_rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'cliente';

// VARIABLE PARA ACTIVAR LA ALERTA BONITA
$mostrar_alerta = false;

// Si el usuario presiona el botón de enviar reporte
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $mensaje = mysqli_real_escape_string($conexion, $_POST['mensaje']);

    // Insertamos la reseña en la tabla 'resenas'
    $query = "INSERT INTO resenas (nombre, mensaje) VALUES ('$nombre', '$mensaje')";
    
    if (mysqli_query($conexion, $query)) {
        $mostrar_alerta = true; // Activamos para que aparezca el aviso estético
    } else {
        echo "Error al guardar: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anderxito - El Nido Macabélico</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</head>
<body>
    <?php if (isset($mostrar_alerta) && $mostrar_alerta): ?>
    <script>
        Swal.fire({
            title: '¡Enviado!',
            text: 'Tu reseña ha sido registrada con éxito.',
            icon: 'success',
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#daff3c'
        });
    </script>
<?php endif; ?>

<?php
    // Conexión opcional a la base de datos
   $conexion = mysqli_connect("sql101.infinityfreeapp.com", "if0_42035482", "ZHf2Z6WM9BG", "if0_42035482_cafeteria");
    // 🚀 JALAMOS LOS CAFÉS DEL ARSENAL DESDE LA BASE DE DATOS
  $consulta_catalogo = "SELECT * FROM productos";
  $resultado_catalogo = mysqli_query($conexion, $consulta_catalogo);
?>

<header>
    <nav>
        <div class="logo-container">
            <img src="img/logo.png" alt="Logo Anderxito" class="logo-img">
            <div class="logo-text">
                <strong class="neon-text">ANDERXITO</strong><br>
                <small>LA GRANDEZA HECHA CAFÉ</small>
            </div>
        </div>
        <ul>
            <li><a href="#inicio">INICIO</a></li>
            <li><a href="#historia">LEYENDA</a></li>
            <li><a href="#menu">ARSENAL</a></li>
            <li><a href="#contacto">UBICACIÓN</a></li>
            <?php if ($usuario_rol === 'admin'): ?>
    <li><a href="admin.php" class="btn-admin-nav">👁️ ADMIN</a></li>
<?php endif; ?>
            <li class="cart-icon">🛒 <span id="cart-count">0</span></li>
            <li class="menu-usuario-container">
   <?php if (isset($_SESSION['usuario'])): ?>
    <span class="usuario-logeado" style="color: var(--amarillo-neon); font-family: 'Impact', sans-serif;">
        👤 <?php echo $_SESSION['usuario']; ?>
    </span>
    
    <div class="usuario-menu-container">
        <button id="btnMiCuenta" class="btn-mi-cuenta" onclick="toggleMenuUsuario()">
            👤 MI CUENTA
        </button>
    </div>

<?php else: ?>
    <div class="usuario-menu-container">
        <button id="btnMiCuenta" class="btn-mi-cuenta" onclick="toggleMenuUsuario()">
            👤 MI CUENTA
        </button>
    </div>
<?php endif; ?>

<ul id="menuUsuarioDropdown" class="dropdown-menu" style="display: none; position: absolute; background-color: #333; padding: 10px; list-style: none; z-index: 9999;">
    <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="perfil.php" style="color: #fff; text-decoration: none; display: block; padding: 5px;">👤 Mi Perfil</a></li>
        <li><a href="logout.php" style="color: #ff4444; text-decoration: none; display: block; padding: 5px;">❌ Cerrar Sesión</a></li>
    <?php else: ?>
        <li><a href="login.php" style="color: #fff; text-decoration: none; display: block; padding: 5px;">🔑 Iniciar Sesión</a></li>
        <li><a href="registrar.php" style="color: #fff; text-decoration: none; display: block; padding: 5px;">Registrarse</a></li>
    <?php endif; ?>
</ul>
</header>

<section id="inicio">
    <div class="hero-content">
        <h1 class="titulo-macabelico">BIENVENIDO AL NIDO</h1>
        <p class="subtitulo">"ÓDIAME MÁS, MI CAFÉ ES TU ENVIDIA"</p>
        <a href="#menu" class="btn-macabelico">VER CATÁLOGO CAMPEÓN</a>
    </div>
</section>

<section id="historia">
    <div class="container-historia">
        <h2 class="neon-text-yellow">NUESTRA DINASTÍA</h2>
        <p class="texto-macabelico">
            Anderxito no nació por casualidad; nació para dominar. Surgimos en las sombras de Coapa, donde solo los más grandes sobreviven. Aquí no servimos café, servimos **jerarquía**. Cada grano es seleccionado con la misma precisión que un gol en una final. Nuestra historia está escrita con letras de oro y el aroma de la victoria. Si buscas algo ordinario, ve a otro lado. Aquí solo hay espacio para la excelencia azulcrema. **Písalo o déjalo.**
        </p>
    </div>
</section>

<section id="menu">
    <h2 class="neon-text-yellow">ARSENAL DE TITULARES</h2>
    <div class="menu-grid">
        <?php while ($cafe = mysqli_fetch_assoc($resultado_catalogo)) { ?>
            <div class="menu-item">
                <img src="img/<?php echo $cafe['imagen']; ?>" alt="<?php echo $cafe['nombre']; ?>">
                <h3>☕ <?php echo $cafe['nombre']; ?></h3>
                <p>Preparado al momento con la calidad del Nido Macabélico.</p>
                <span class="precio">$<?php echo number_format($cafe['precio'], 2); ?></span>
                <button onclick="agregarAlCarrito('<?php echo $cafe['nombre']; ?>', <?php echo $cafe['precio']; ?>)">
                    AÑADIR
                </button>
            </div>
        <?php } ?>
        </div>
    </div>
</section>

<section id="contacto">
    <h2 class="neon-text-yellow">ESTRATEGIA Y UBICACIÓN</h2>
    
    <div class="contacto-flex" style="display: flex; gap: 30px; max-width: 1100px; margin: 0 auto; flex-wrap: wrap; align-items: stretch;">
        
        <div class="mapa-box" style="flex: 1; min-width: 300px; border: 3px solid #daff3c; background: #000; height: 380px;">
            <iframe src="https://maps.google.com/maps?q=Club%20Am%C3%A9rica%20Coapa&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="tarjeta-contacto" style="flex: 1; min-width: 300px; background: #000; padding: 30px; border-radius: 10px; border-bottom: 5px solid #daff3c;">
            <form action="" method="POST">
                <input type="text" name="nombre" placeholder="Escribe tu reseña aqui abajo" style="width: 100%; padding: 12px; margin-bottom: 15px; background: #37393d; color: #fff; border: 1px solid #555; border-radius: 5px;" required>
                <textarea name="mensaje" placeholder="Danos tu opinion sobre nuestros servicios" rows="5" style="width: 100%; padding: 12px; margin-bottom: 15px; background: #37393d; color: #fff; border: 1px solid #555; border-radius: 5px; resize: none;" required></textarea>
                <button type="submit" name="enviar" class="btn-macabelico" style="width: 100%; padding: 12px; font-size: 16px;">ENVIAR REPORTE</button>
            </form>
        </div>

    </div>
</section>

<div id="cart-modal" class="cart-modal">
    <div class="cart-content">
        <h3>TU ALINEACIÓN</h3>
        <ul id="lista-carrito"></ul>
        <hr style="border: 1px solid var(--amarillo-neon); margin: 10px 0;">
        <p>Total a Pagar: $<span id="total-precio">0</span></p>

        <?php if (isset($_SESSION['usuario'])): ?>
    <a href="pago.php" class="btn-macabelico" style="text-decoration: none; display: inline-block; text-align: center;">CONFIRMAR</a>
<?php else: ?>
    <button class="btn-macabelico" onclick="alertaLogin()">CONFIRMAR</button>
<?php endif; ?>

        <button class="btn-cerrar" onclick="cerrarCarrito()">VOLVER</button>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> ANDERXITO COFFEE - EL MÁS GRANDE</p>
</footer>
<script>
    function alertaLogin() {
    Swal.fire({
        title: '¡ALTO AHÍ, CAMPEÓN!',
        text: 'Debes iniciar sesión o registrarte para realizar tu compra.',
        icon: 'warning',
        background: '#1a1a1a',
        color: '#fff',
        confirmButtonColor: '#ff0055',
        confirmButtonText: 'Ir al Login',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#444'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'login.php';
        }
    });
}
let carrito = [];
let total = 0;

function agregarAlCarrito(nombre, precio) {
    if (typeof carrito === 'undefined') {
        carrito = [];
        total = 0;
    }

    // Guardamos el café en la lista
    carrito.push({nombre, precio});
    total += precio;
    
    // Actualizamos el contador flotante si existe
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.innerText = carrito.length;
    }
    
    // Mandamos a llamar a la función que dibuja el carrito
    actualizarCarrito();
} // <--- Al pegar este bloque, verás que ESTA llave se vuelve amarilla o blanca

function actualizarCarrito() {
    // Buscamos tu contenedor del carrito
    const lista = document.getElementById('lista-carrito') || document.getElementById('cart-items');

    if (lista) {
        lista.innerHTML = "";
        let total = 0; // Inicializamos el total para que calcule bien

        // Recorremos los cafés y los agregamos a la lista con sus controles
        carrito.forEach((item, index) => {
            if (!item.cantidad) item.cantidad = 1;
            
            // Sumamos al total del precio
            total += item.precio * item.cantidad;

            const li = document.createElement('li');
            
            li.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; gap: 10px;">
                    <span>${item.nombre} - $${item.precio}</span>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button onclick="cambiarCantidad(${index}, -1)" style="background: #444; color: #fff; border: none; padding: 2px 8px; cursor: pointer; border-radius: 4px; font-weight: bold;">-</button>
                        
                        <span style="color: #fff; font-weight: bold;">${item.cantidad}</span>
                        
                        <button onclick="cambiarCantidad(${index}, 1)" style="background: var(--amarillo-neon); color: #000; border: none; padding: 2px 8px; cursor: pointer; border-radius: 4px; font-weight: bold;">+</button>
                        
                        <button onclick="eliminarDelCarrito(${index})" style="background: #ff4444; color: #fff; border: none; padding: 4px 8px; cursor: pointer; border-radius: 4px; font-size: 12px; font-weight: bold;">Quitar</button>
                    </div>
                </div>
            `;

            // Mantener los estilos neón que ya tenías configurados
            li.style.color = "var(--amarillo-neon)";
            li.style.listStyle = "none";
            li.style.margin = "15px 0";
            li.style.borderBottom = "1px solid #333";
            li.style.paddingBottom = "8px";

            lista.appendChild(li);
        });

        // Actualización del total en pantalla
        const totalDisplay = document.getElementById('total-precio') || document.getElementById('total-pagar');
        if (totalDisplay) {
            totalDisplay.innerText = "$" + total;
        }
    }
}

// --- FUNCIONES MATEMÁTICAS PARA LOS BOTONES ---
function cambiarCantidad(indice, cambio) {
    if (!carrito[indice].cantidad) {
        carrito[indice].cantidad = 1;
    }

    carrito[indice].cantidad += cambio;
    
    if (carrito[indice].cantidad < 1) {
        eliminarDelCarrito(indice);
        return;
    }
    actualizarCarrito();
}

function eliminarDelCarrito(indice) {
    carrito.splice(indice, 1);
    
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Producto eliminado del nido',
        background: '#1a1a1a',
        color: '#fff',
        showConfirmButton: false,
        timer: 1500
    });
    
    actualizarCarrito();
}
// Abrir el carrito al presionar el icono 🛒
document.querySelector('.cart-icon').onclick = function() {
    document.getElementById('cart-modal').style.display = 'flex';
};

// Cerrar el carrito con el botón VOLVER
function cerrarCarrito() {
    document.getElementById('cart-modal').style.display = 'none';
}

// Guardar el pedido final en la base de datos
function enviarPedidoAlNido() {
    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return;
    }
    let listaProductos = carrito.map(item => item.nombre).join(", ");
    
    let totalCantidad = 0;
    carrito.forEach(item => { totalCantidad += parseInt(item.cantidad || 1); });

    let totalReal = 0;
    carrito.forEach(item => { totalReal += (parseFloat(item.precio || 40) * parseInt(item.cantidad || 1)); });

    let datos = new FormData();
    datos.append("productos", listaProductos);
    datos.append("total", totalReal);        // Manda los $80 reales
    datos.append("cantidad", totalCantidad); // Manda el 2 real

    fetch("guardar_pedido.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(respuesta => {
        if (respuesta.trim() === "pedido_exitoso") {
            // ¡PUM! Tu notificación neón personalizada entra en acción
            mostrarNotificacionNeon("✅ ¡PEDIDO ENVIADO A LA COCINA DEL NIDO CON ÉXITO!");
            
            // Vaciamos el carrito de manera limpia
            carrito = [];
            total = 0;
            document.getElementById('cart-count').innerText = 0;
            actualizarCarrito();
            cerrarCarrito();
        } else {
            alert("Hubo un error al guardar tu pedido.");
        }
    })
    .catch(err => console.log("Error:", err));
}

// Variable que necesita el carrito para saber si iniciaste sesión
const usuarioLogeado = <?php echo isset($_SESSION['usuario']) ? 'true' : 'false'; ?>;

// Función para abrir y cerrar el menú de usuario al darle clic
function toggleMenuUsuario() {
    const dropdown = document.getElementById('menuUsuarioDropdown');
    if (dropdown) {
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    } else {
        console.log("Error: no se encontro el menu con ID 'menuUsuarioDropdown'.");
    }
} 

// Cerrar el menú automáticamente si el usuario hace clic en cualquier otra parte
window.addEventListener('click', function(event) {
    const dropdown = document.getElementById('menuUsuarioDropdown');
    const boton = document.getElementById('btnMiCuenta');
    
    // Seguro 1: Validamos si el menú existe y está abierto
    if (dropdown && dropdown.style.display === 'block') {
        // Seguro 2: Validamos si el botón de Mi Cuenta existe en pantalla
        if (boton) {
            if (!boton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        } else {
            // Si el botón no existe (usuario no logeado), solo cuidamos el clic fuera del menú
            if (!dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        }
    }
});

// Función para mostrar la notificación neón del carrito
function mostrarNotificacionNeon(mensaje) {
    const noti = document.getElementById('notificacion-neon');
    if (noti) {
        noti.innerText = mensaje;
        noti.style.display = 'block';
        setTimeout(() => {
            noti.style.display = 'none';
        }, 3000);
    }
}

function toggleMenuUsuario() {
    // Buscamos el menú directamente por su ID único
    const dropdown = document.getElementById('menuUsuarioDropdown');
    
    if (dropdown) {
        // Vemos qué estilo tiene en línea en ese momento
        const displayActual = dropdown.style.display;
        
        // Si está vacío o es none, lo mostramos; si no, lo ocultamos
        if (displayActual === 'none' || displayActual === '') {
            dropdown.style.setProperty('display', 'block', 'important');
        } else {
            dropdown.style.setProperty('display', 'none', 'important');
        }
    }
}

// Cerrar si hacen clic en cualquier otro lado
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('menuUsuarioDropdown');
    // Buscamos si el clic fue en un botón con la clase del menú de cuenta
    const esBoton = event.target.closest('.btn-mi-cuenta');
    
    if (dropdown && dropdown.style.display === 'block') {
        // Si no se le dio clic al botón ni al menú, lo cerramos
        if (!esBoton && !dropdown.contains(event.target)) {
            dropdown.style.setProperty('display', 'none', 'important');
        }
    }
});
</script>
</body>
</html>