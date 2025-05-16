<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $tipo_promo = (int) $_POST['tipo_promo'];
    $precio = (float) $_POST['precio'];
    $descuento = (float) $_POST['descuento'];
    $productos = $_POST['productos'] ?? [];

    if ($nombre === '' || $tipo_promo <= 0 || $precio <= 0 || count($productos) === 0) {
        header('Location: ../views/crear_combo.php?mensaje=Datos inválidos');
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Insertar combo
        $stmt = $pdo->prepare("INSERT INTO combo (nombre, id_tipo_promo, precio_combo, descuento) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $tipo_promo, $precio, $descuento]);
        $id_combo = $pdo->lastInsertId();

        // Insertar productos del combo
        $stmtProd = $pdo->prepare("INSERT INTO combo_producto (id_combo, id_producto, cantidad) VALUES (?, ?, ?)");
        foreach ($productos as $item) {
            list($id_producto, $cantidad) = explode(':', $item);
            $stmtProd->execute([$id_combo, (int)$id_producto, (int)$cantidad]);
        }

        $pdo->commit();
        header('Location: ../views/ver_combos.php?mensaje=Combo creado exitosamente');
    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: ../views/crear_combo.php?mensaje=Error al crear combo: ' . $e->getMessage());
    }
}

// Eliminar combo
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    try {
        $stmt = $pdo->prepare("DELETE FROM combo WHERE id_combo = ?");
        $stmt->execute([$id]);
        header('Location: ../views/ver_combos.php?mensaje=Combo eliminado');
    } catch (Exception $e) {
        header('Location: ../views/ver_combos.php?mensaje=Error al eliminar combo');
    }
}
