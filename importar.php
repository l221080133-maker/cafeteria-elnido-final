<?php
// 1. Conexión automática con Railway
$hostname = $_ENV['MYSQLHOST'];
$username = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];
$database = $_ENV['MYSQLDATABASE'];
$port     = $_ENV['MYSQLPORT'];

$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("Error al conectar a MySQL: " . mysqli_connect_error());
}

// 2. Ruta del archivo SQL original
$archivo_sql = 'anderxito_db.sql';

if (!file_exists($archivo_sql)) {
    die("Error: No encontré el archivo anderxito_db.sql en la carpeta. Asegúrate de subirlo a GitHub.");
}

// 3. Leer y ejecutar el archivo línea por línea
$lineas = file($archivo_sql);
$comando_sql = '';
$errores = 0;

foreach ($lineas as $linea) {
    // Ignorar comentarios y líneas vacías
    if (substr($linea, 0, 2) == '--' || $linea == '' || substr($linea, 0, 2) == '/*') {
        continue;
    }

    $comando_sql .= $linea;

    // Si encuentra un punto y coma al final, ejecuta esa instrucción
    if (substr(trim($linea), -1, 1) == ';') {
        if (!mysqli_query($conexion, $comando_sql)) {
            $errores++;
        }
        $comando_sql = '';
    }
}

if ($errores == 0) {
    echo "<h1 style='color:green; text-align:center; margin-top:50px;'>¡Base de datos importada con éxito total en Railway! ☕🦅🚀</h1>";
    echo "<p style='text-align:center;'>Ya puedes ir a iniciar sesión en tu página principal.</p>";
} else {
    echo "<h1 style='color:orange; text-align:center; margin-top:50px;'>Importación completada con algunos avisos.</h1>";
    echo "<p style='text-align:center;'>Prueba entrar a tu página para ver si tus tablas e inicio de sesión ya funcionan.</p>";
}
?>