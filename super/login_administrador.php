<?php
include 'db.php';

// Procesar el inicio de sesión para administradores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_administrador'])) {
    $usuario = $_POST['usuario_admin'];
    $contrasena = $_POST['contrasena_admin'];
    
    // Verificar las credenciales del administrador
    $sql = "SELECT * FROM Administradores WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Iniciar sesión exitosa para administrador
        session_start();
        $_SESSION['admin'] = $usuario;
        header("Location: panel_admin.php");
        exit();
    } else {
        // Mostrar mensaje de error si las credenciales son incorrectas
        $mensaje_error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión como Administrador</title>
</head>
<body>
    <h1>Iniciar Sesión como Administrador</h1>
    <?php if (isset($mensaje_error)): ?>
        <p><?php echo $mensaje_error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="usuario_admin">Usuario:</label><br>
        <input type="text" id="usuario_admin" name="usuario_admin" required><br>
        <label for="contrasena_admin">Contraseña:</label><br>
        <input type="password" id="contrasena_admin" name="contrasena_admin" required><br><br>
        <input type="submit" name="submit_administrador" value="Iniciar Sesión">
    </form>
</body>
</html>
