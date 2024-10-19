<?php
session_start();
include 'db.php'; // Incluir archivo de conexión a la base de datos

$id_cliente = $_SESSION['id_cliente']; // Obtener el ID del cliente desde la sesión

$sql_carrito = "SELECT p.nombre, p.precio, c.cantidad FROM carrito c JOIN productos p ON c.id_producto = p.id WHERE c.id_cliente = $id_cliente";
$result_carrito = $conn->query($sql_carrito);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
        </tr>
        <?php while ($row = $result_carrito->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="pagar.php">Pagar</a></p>
</body>
</html>
