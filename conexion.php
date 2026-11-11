
<?php
//para la sig practica esto se va a tner que modificar 
$conexion = new mysqli("localhost", "root", "", "gominolas", 3306);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
