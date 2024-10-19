<?php
session_start();
include 'db.php'; // Incluir archivo de conexión a la base de datos

$id_cliente = $_SESSION['id_cliente']; // Obtener el ID del cliente desde la sesión

// Obtener los productos comprados
$sql_compra = "SELECT p.nombre, p.precio, c.cantidad FROM carrito c JOIN productos p ON c.id_producto = p.id WHERE c.id_cliente = $id_cliente";
$result_compra = $conn->query($sql_compra);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Compra</title>
</head>
<body>
    <h1>Ticket de Compra</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
        <?php
        $total = 0;
        while ($row = $result_compra->fetch_assoc()): 
            $subtotal = $row['precio'] * $row['cantidad'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $subtotal; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <p>Total: <?php echo $total; ?></p>
</body>
</html>
