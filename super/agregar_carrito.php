<?php
include 'db.php'; // Incluir archivo de conexión a la base de datos
session_start();

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login_cliente.php");
    exit();
}

// Obtener el ID del cliente desde la sesión
$id_cliente = $_SESSION['id'];

// Obtener el ID del producto a agregar al carrito
$id_producto = $_GET['id'];

// Desactivar temporalmente la restricción de clave externa
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Realizar la inserción en la tabla carrito
$sql_insertar = "INSERT INTO carrito (id_cliente, id_producto) VALUES ($id_cliente, $id_producto)";
$resultado = $conn->query($sql_insertar);

// Activar la restricción de clave externa nuevamente
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Producto agregado al carrito correctamente.";
} else {
    echo "Error al agregar el producto al carrito.";
}

// Agregar un enlace para regresar a la página de selección de productos
echo '<br><br><a href="panel_usuario.php">Volver a la selección de productos</a>';
?>
