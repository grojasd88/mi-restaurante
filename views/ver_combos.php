<?php
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM vista_combo_detalle ORDER BY id_combo");
$combos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Combos</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Combos Disponibles</h2>

    <a href="crear_combo.php" class="agregar-btn">+ Crear Nuevo Combo</a>

    <?php if (empty($combos)): ?>
        <div class="mensaje">No hay combos registrados.</div>
    <?php else: ?>
        <?php 
            $agrupados = [];
            foreach ($combos as $fila) {
                $agrupados[$fila['id_combo']]['datos'] = $fila;
                $agrupados[$fila['id_combo']]['productos'][] = $fila;
            }
        ?>

        <?php foreach ($agrupados as $combo): ?>
        <div class="container">
            <h3><?= htmlspecialchars($combo['datos']['nombre_combo']) ?> (<?= htmlspecialchars($combo['datos']['tipo_promo']) ?>)</h3>
            <p><strong>Precio:</strong> $<?= number_format($combo['datos']['precio_combo'], 2) ?> | <strong>Descuento:</strong> <?= $combo['datos']['descuento'] ?>%</p>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($combo['productos'] as $prod): ?>
                    <tr>
                        <td><?= htmlspecialchars($prod['nombre_producto']) ?></td>
                        <td><?= htmlspecialchars($prod['tipo_producto']) ?></td>
                        <td>$<?= number_format($prod['precio_producto'], 2) ?></td>
                        <td><?= $prod['cantidad'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="editar_combo.php?id=<?= $combo['datos']['id_combo'] ?>" class="editar-link">Editar</a> |
            <a href="../controllers/comboController.php?eliminar=<?= $combo['datos']['id_combo'] ?>" 
               onclick="return confirm('¿Estás seguro de eliminar este combo?')" 
               class="eliminar-link">Eliminar</a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
