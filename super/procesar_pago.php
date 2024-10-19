<?php
include 'db.php'; // Incluir archivo de conexión a la base de datos
session_start();

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login_cliente.php");
    exit();
}

// Obtener información de pago del formulario
$tarjeta = $_POST['tarjeta'];
$direccion = $_POST['direccion'];

// Obtener el ID del cliente desde la sesión
$id_cliente = $_SESSION['id'];

// Insertar la compra en la base de datos
$sql_insertar_compra = "INSERT INTO compras (id_cliente, tarjeta_credito, direccion_envio) VALUES ('$id_cliente', '$tarjeta', '$direccion')";
$resultado_compra = $conn->query($sql_insertar_compra);

if ($resultado_compra) {
    // Éxito al registrar la compra
    echo "Compra realizada con éxito.";
    // También puedes redirigir al usuario a una página de confirmación o mostrar un mensaje de éxito
} else {
    // Error al registrar la compra
    echo "Error al procesar el pago.";
}

?>
