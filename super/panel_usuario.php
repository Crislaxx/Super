<?php
include 'db.php'; // Incluir archivo de conexión a la base de datos
session_start();

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login_cliente.php");
    exit();
}

// Inicializar arreglo para el carrito de compras
$carrito = [];

// Función para agregar un producto al carrito
function agregarAlCarrito($id, $nombre, $precio) {
    global $carrito;
    $carrito[] = array("id" => $id, "nombre" => $nombre, "precio" => $precio);
}

// Función para calcular el total de la compra
function calcularTotal() {
    global $carrito;
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['precio'];
    }
    return $total;
}

// Obtener productos disponibles (por ejemplo, solo bebidas)
$sql_bebidas = "SELECT * FROM productos WHERE categoria = 'Bebida'";
$result_bebidas = $conn->query($sql_bebidas);

// Obtener productos disponibles (por ejemplo, solo alimentos)
$sql_alimentos = "SELECT * FROM productos WHERE categoria = 'Alimento'";
$result_alimentos = $conn->query($sql_alimentos);

// Procesar la solicitud de agregar al carrito si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $sql_producto = "SELECT * FROM productos WHERE id = $id_producto";
    $result_producto = $conn->query($sql_producto);
    if ($result_producto->num_rows > 0) {
        $row_producto = $result_producto->fetch_assoc();
        agregarAlCarrito($row_producto['id'], $row_producto['nombre'], $row_producto['precio']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Usuario</title>
</head>
<body>
    <h1>Bienvenido al Panel de Usuario</h1>

    <h2>Bebidas Disponibles</h2>
    <ul>
        <?php while ($row_bebida = $result_bebidas->fetch_assoc()): ?>
            <li>
                <?php echo $row_bebida['nombre']; ?> - $<?php echo $row_bebida['precio']; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="id_producto" value="<?php echo $row_bebida['id']; ?>">
                    <input type="submit" name="agregar_carrito" value="Agregar al Carrito">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2>Alimentos Disponibles</h2>
    <ul>
        <?php while ($row_alimento = $result_alimentos->fetch_assoc()): ?>
            <li>
                <?php echo $row_alimento['nombre']; ?> - $<?php echo $row_alimento['precio']; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="id_producto" value="<?php echo $row_alimento['id']; ?>">
                    <input type="submit" name="agregar_carrito" value="Agregar al Carrito">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2>Carrito de Compras</h2>
    <ul>
        <?php foreach ($carrito as $producto): ?>
            <li><?php echo $producto['nombre']; ?> - $<?php echo $producto['precio']; ?></li>
        <?php endforeach; ?>
    </ul>

    <p>Total: $<?php echo calcularTotal(); ?></p>
    <button onclick="pagar()">Pagar</button>

    <p><a href="logout.php">Cerrar Sesión</a></p>
</body>
</html>

