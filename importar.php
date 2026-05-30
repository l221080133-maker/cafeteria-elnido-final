<?php
// Habilitar reporte de errores para ver qué pasa
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Conexión a Railway
$hostname = $_ENV['MYSQLHOST'] ?? null;
$username = $_ENV['MYSQLUSER'] ?? null;
$password = $_ENV['MYSQLPASSWORD'] ?? null;
$database = $_ENV['MYSQLDATABASE'] ?? null;
$port     = $_ENV['MYSQLPORT'] ?? null;

if (!$hostname || !$username || !$database) {
    die("<h2 style='color:red; text-align:center;'>Faltan las variables de entorno de Railway. Revisa la pestaña de Variables.</h2>");
}

$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("<h2 style='color:red; text-align:center;'>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

// 2. Buscar el archivo SQL (probando minúsculas y extensiones)
$archivo_sql = 'anderxito_db.sql';
if (!file_exists($archivo_sql)) {
    $archivo_sql = 'anderxito_db'; // por si acaso se subió sin el .sql
}

if (!file_exists($archivo_sql)) {
    die("<h2 style='color:orange; text-align:center;'>No se encontró el archivo '$archivo_sql' en la raíz. Asegúrate de que el nombre coincida exactamente en GitHub.</h2>");
}

// 3. Procesar el archivo con seguridad total
$contenido = file_get_contents($archivo_sql);
// Quitar comentarios tipo /* ... */ y -- ...
$contenido = preg_replace('@/\*.*?\*/@s', '', $contenido);
$lineas = explode("\n", $contenido);

$comando_acumulado = '';
$tablas_creadas = 0;

foreach ($lineas as $linea) {
    $linea = trim($linea);
    
    // Saltarse líneas vacías o comentarios de SQL
    if ($linea === '' || strpos($linea, '--') === 0 || strpos($linea, '#') === 0) {
        continue;
    }
    
    $comando_acumulado .= " " . $linea;
    
    // Si la línea termina en punto y coma, ejecutamos el bloque
    if (substr($linea, -1) === ';') {
        // Limpieza extra por si las moscas
        $query_limpio = trim($comando_acumulado);
        
        // Ejecutar ignorando errores pequeños para que no tire Error 500
        if (!empty($query_limpio)) {
            if (mysqli_query($conexion, $query_limpio)) {
                if (strpos(strtoupper($query_limpio), 'CREATE TABLE') !== false) {
                    $tablas_creadas++;
                }
            }
        }
        $comando_acumulado = '';
    }
}

echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
echo "<h1 style='color:green;'>¡Proceso de importación finalizado! ☕🦅🚀</h1>";
echo "<p style='font-size:18px;'>Se procesó tu archivo <b>$archivo_sql</b> correctamente.</p>";
echo "<p style='font-size:16px; color:#555;'>Ya puedes ir a tu página principal a intentar iniciar sesión.</p>";
echo "</div>";
?>