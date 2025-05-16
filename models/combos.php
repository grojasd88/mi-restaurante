<?php
require_once(__DIR__ . '/../config/db.php');

function agregarCombo($nombre, $tipo_promo, $precio, $descuento, $productos) {
    global $pdo;

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
            $stmtProd->execute([
                $id_combo,
                (int)$id_producto,
                (int)$cantidad
            ]);
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function eliminarCombo($id_combo) {
    global $pdo;

    try {
        $pdo->beginTransaction();

        // Eliminar productos 
        $pdo->prepare("DELETE FROM combo_producto WHERE id_combo = ?")->execute([$id_combo]);

        // Eliminar el combo
        $pdo->prepare("DELETE FROM combo WHERE id_combo = ?")->execute([$id_combo]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
