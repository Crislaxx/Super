<?php
include 'db.php'; // Incluir archivo de conexión a la base de datos

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    
    // Consultar la base de datos para verificar las credenciales del cliente
    $sql = "SELECT id FROM clientes WHERE nombre = '$nombre_usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // Iniciar sesión y configurar $_SESSION['id'] con el ID del cliente
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];

        // Redirigir al panel de usuario
        header("Location: panel_usuario.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, mostrar un mensaje de error
        $error_message = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión como Cliente</title>
</head>
<body>
    <h1>Iniciar Sesión como Cliente</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre_usuario">Nombre de Usuario:</label><br>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <?php
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
</body>
</html>
