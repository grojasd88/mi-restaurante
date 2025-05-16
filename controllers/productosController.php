<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../models/productos.php');

// AGREGAR PRODUCTO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $id_tipo_producto = $_POST['id_tipo_producto'];
    $precio_producto = $_POST['precio_producto'];

    // Validaciones
    if (empty($nombre)) {
        die("⚠️ El nombre del producto es obligatorio.");
    }

    if (!is_numeric($precio_producto) || $precio_producto <= 0) {
        die("⚠️ El precio debe ser mayor que cero.");
    }

    if (empty($id_tipo_producto)) {
        die("⚠️ Selecciona un tipo de producto.");
    }

    // Insertar producto
    if (agregarProducto($nombre, $id_tipo_producto, $precio_producto)) {
        header("Location: ../views/ver_productos.php?mensaje=Producto+agregado");
        exit();
    } else {
        echo "❌ Error al insertar el producto.";
    }
}

// EDITAR PRODUCTO (cuando envíes desde editar_producto.php, usa name="editar")
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = trim($_POST['nombre']);
    $id_tipo_producto = $_POST['id_tipo_producto'];
    $precio_producto = $_POST['precio_producto'];

    if (empty($nombre)) {
        die("⚠️ El nombre del producto es obligatorio.");
    }

    if (!is_numeric($precio_producto) || $precio_producto <= 0) {
        die("⚠️ El precio debe ser mayor que cero.");
    }

    if (empty($id_tipo_producto)) {
        die("⚠️ Selecciona un tipo de producto.");
    }

    if (editarProducto($id_producto, $nombre, $id_tipo_producto, $precio_producto)) {
        header("Location: ../views/ver_productos.php?mensaje=Producto+actualizado");
        exit();
    } else {
        echo "❌ Error al actualizar el producto.";
    }
}

// ELIMINAR PRODUCTO
if (isset($_GET['eliminar'])) {
    require_once(__DIR__ . '/../config/db.php'); // Asegúrate que $pdo esté disponible
    $id_producto = $_GET['eliminar'];

    $sql = "DELETE FROM menu WHERE id_producto = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id_producto])) {
        header("Location: ../views/ver_productos.php?mensaje=Producto+eliminado");
        exit();
    } else {
        echo "❌ Error al eliminar el producto.";
    }
}
?>
