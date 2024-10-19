<?php
require_once("../includes/db.php"); // Incluir el archivo de conexión a la base de datos

session_start();

if ($_SESSION["rol"] != "proveedor") {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y validar los datos del formulario de agregar producto
    $nombre_producto = $_POST["nombre_producto"];
    $precio_producto = $_POST["precio_producto"];
    $descripcion_producto = $_POST["descripcion_producto"];
    $stock_producto = $_POST["stock_producto"];

    // Insertar el producto en la base de datos
    $sql = "INSERT INTO productos (nombre, precio, descripcion, stock) VALUES ('$nombre_producto', $precio_producto, '$descripcion_producto', $stock_producto)";
    if ($conn->query($sql) === TRUE) {
        $mensaje_exito = "Producto agregado con éxito.";
    } else {
        $mensaje_error = "Error al agregar el producto: " . $conn->error;
    }
}

// Consultar y mostrar la lista de productos existentes
$sql_productos = "SELECT * FROM productos";
$result_productos = $conn->query($sql_productos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Proveedor</title>
</head>
<body>
    <h1>Panel de Proveedor</h1>
    <h2>Agregar Producto</h2>
    <?php if (isset($mensaje_exito)) { echo "<p>$mensaje_exito</p>"; } ?>
    <?php if (isset($mensaje_error)) { echo "<p>$mensaje_error</p>"; } ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Nombre del Producto: <input type="text" name="nombre_producto"><br>
        Precio del Producto: <input type="text" name="precio_producto"><br>
        Descripción del Producto: <input type="text" name="descripcion_producto"><br>
        Stock del Producto: <input type="text" name="stock_producto"><br>
        <input type="submit" value="Agregar Producto">
    </form>

    <h2>Productos Disponibles</h2>
    <ul>
        <?php
        if ($result_productos->num_rows > 0) {
            while ($row_producto = $result_productos->fetch_assoc()) {
                echo "<li>" . $row_producto["nombre"] . " - Precio: $" . $row_producto["precio"] . " - Stock: " . $row_producto["stock"] . "</li>";
            }
        } else {
            echo "No hay productos disponibles.";
        }
        ?>
    </ul>

    <p><a href="../logout.php">Cerrar Sesión</a></p>
</body>
</html>
