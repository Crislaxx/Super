<?php
session_start();
include 'db.php'; // Incluir archivo de conexión a la base de datos

$id_cliente = $_SESSION['id_cliente']; // Obtener el ID del cliente desde la sesión

// Obtener los productos del carrito
$sql_carrito = "SELECT * FROM carrito WHERE id_cliente = $id_cliente";
$result_carrito = $conn->query($sql_carrito);

// Procesar el pago
// Aquí puedes realizar las acciones necesarias para procesar el pago, como calcular el total, actualizar el stock, etc.

// Eliminar los productos del carrito después de pagar
$sql_eliminar = "DELETE FROM carrito WHERE id_cliente = $id_cliente";
$conn->query($sql_eliminar);

header("Location: ticket.php"); // Redirigir al usuario al ticket de compra
exit();
?>
