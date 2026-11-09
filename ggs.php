
<?php
require_once "conexion.php";

$mensaje = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = trim($_POST["nombres"] ?? "");
    $apellidos = trim($_POST["apellidos"] ?? "");

    if ($nombres === "" || $apellidos === "") {
        $mensaje = "Por favor, completa todos los campos.";
        $tipo = "error";
    } elseif (strlen($nombres) > 100 || strlen($apellidos) > 100) {
        $mensaje = "Los campos no deben superar 100 caracteres.";
        $tipo = "error";
    } else {

        $sql = "INSERT INTO integrantes (nombres, apellidos) VALUES (?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombres, $apellidos);

        if ($stmt->execute()) {
            $mensaje = "¡Integrante registrado correctamente!";
            $tipo = "exito";
        } else {
            $mensaje = "Error al guardar el integrante.";
            $tipo = "error";
        }

        $stmt->close();
    }
}

$resultado = $conexion->query("SELECT * FROM integrantes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Integrantes</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 30px 15px;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h1, h2 {
            text-align: center;
            color: #263445;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .mensaje {
            padding: 12px;
            margin-top: 15px;
            border-radius: 6px;
            text-align: center;
        }

        .exito {
            background: #d1fae5;
            color: #065f46;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Registro de Integrantes</h1>
    <p style="text-align:center;">
        Ingresa los datos del nuevo integrante.
    </p>

    <?php if ($mensaje != ""): ?>
        <div class="mensaje <?php echo $tipo; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <label for="nombres">Nombres:</label>
        <input
            type="text"
            id="nombres"
            name="nombres"
            maxlength="100"
            required
            placeholder="Ingresa los nombres"
        >

        <label for="apellidos">Apellidos:</label>
        <input
            type="text"
            id="apellidos"
            name="apellidos"
            maxlength="100"
            required
            placeholder="Ingresa los apellidos"
        >

        <button type="submit">Guardar integrante</button>

    </form>

    <h2>Integrantes registrados</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
        </tr>

        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($fila["id"]); ?></td>
            <td><?php echo htmlspecialchars($fila["nombres"]); ?></td>
            <td><?php echo htmlspecialchars($fila["apellidos"]); ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>

<?php
$conexion->close();
?>
