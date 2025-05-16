<?php
require_once(__DIR__ . '/../config/db.php');

function agregarProducto($nombre, $tipo_producto, $precio) {
    global $pdo; // Importante para usar la conexión de DB

    // Verifica si la consulta está bien escrita
    $sql = "INSERT INTO menu (nombre, id_tipo_producto, precio_producto) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta
    return $stmt->execute([$nombre, $tipo_producto, $precio]);
}
function editarProducto($id_producto, $nombre, $tipo_producto, $precio) {
    global $pdo;

    $sql = "UPDATE menu SET nombre = ?, id_tipo_producto = ?, precio_producto = ? WHERE id_producto = ?";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([$nombre, $tipo_producto, $precio, $id_producto]);
}
function eliminarProducto($id_producto) {
    global $pdo;

    $sql = "DELETE FROM menu WHERE id_producto = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_producto]);
}