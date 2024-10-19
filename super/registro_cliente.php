<?php
include 'db.php';

$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_registro'])) {
    $nombre = $_POST['nombre_cliente'];
    $telefono = $_POST['telefono_cliente'];
    $direccion = $_POST['direccion_cliente'];
    $contrasena = $_POST['contrasena_cliente'];

    // Insertar los datos del nuevo cliente en la base de datos
    $sql = "INSERT INTO Clientes (nombre, telefono, direccion, contrasena) VALUES ('$nombre', '$telefono', '$direccion', '$contrasena')";
    if ($conn->query($sql) === TRUE) {
        // Redirigir al cliente a la página de inicio de sesión después del registro exitoso
        header("Location: login_cliente.php");
        exit();
    } else {
        // Mostrar mensaje de error si hay un problema con el registro
        $mensaje_error = "Error al registrar al cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Cliente</title>
</head>
<body>
    <h1>Registro de Cliente</h1>
    <?php if ($mensaje_error != ""): ?>
        <p><?php echo $mensaje_error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre_cliente">Nombre:</label><br>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required><br>
        <label for="telefono_cliente">Teléfono:</label><br>
        <input type="text" id="telefono_cliente" name="telefono_cliente" required><br>
        <label for="direccion_cliente">Dirección:</label><br>
        <input type="text" id="direccion_cliente" name="direccion_cliente" required><br>
        <label for="contrasena_cliente">Contraseña:</label><br>
        <input type="password" id="contrasena_cliente" name="contrasena_cliente" required><br><br>
        <input type="submit" name="submit_registro" value="Guardar">
    </form>
</body>
</html>
