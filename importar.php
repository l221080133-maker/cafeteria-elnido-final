<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión usando getenv() que es 100% compatible con Railway
$hostname = getenv('MYSQLHOST');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$database = getenv('MYSQLDATABASE');
$port     = getenv('MYSQLPORT');

if (!$hostname || !$username || !$database) {
    die("<h2 style='color:red; text-align:center;'>Faltan las variables de entorno de Railway. Revisa la pestaña de Variables.</h2>");
}

$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("<h2 style='color:red; text-align:center;'>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

$archivo_sql = 'anderxito_db.sql';
if (!file_exists($archivo_sql)) {
    $archivo_sql = 'anderxito_db';
}

if (!file_exists($archivo_sql)) {
    die("<h2 style='color:orange; text-align:center;'>No se encontró el archivo '$archivo_sql'.</h2>");
}

$contenido = file_get_contents($archivo_sql);
$contenido = preg_replace('@/\*.*?\*/@s', '', $contenido);
$lineas = explode("\n", $contenido);

$comando_acumulado = '';

foreach ($lineas as $linea) {
    $linea = trim($linea);
    if ($linea === '' || strpos($linea, '--') === 0 || strpos($linea, '#') === 0) {
        continue;
    }
    $comando_acumulado .= " " . $linea;
    if (substr($linea, -1) === ';') {
        $query_limpio = trim($comando_acumulado);
        if (!empty($query_limpio)) {
            mysqli_query($conexion, $query_limpio);
        }
        $comando_acumulado = '';
    }
}

echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
echo "<h1 style='color:green;'>¡Proceso de importación finalizado! ☕🦅🚀</h1>";
echo "<p style='font-size:18px;'>Se procesó tu archivo <b>$archivo_sql</b> correctamente.</p>";
echo "</div>";
?>