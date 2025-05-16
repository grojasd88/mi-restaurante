<?php
require_once(__DIR__ . '/../config/db.php');

// Obtener todos los productos con el tipo de producto
$query = "SELECT menu.*, tipo_producto.tipo_producto FROM menu 
          INNER JOIN tipo_producto ON menu.id_tipo_producto = tipo_producto.id_tipo_producto";
$stmt = $pdo->query($query);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Productos</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Productos</h2>

<!-- ✅ Mensaje tipo toast si se agregó/actualizó/eliminó un producto -->
<?php if (isset($_GET['mensaje'])): ?>
    <div class="toast show" id="toast"><?= htmlspecialchars($_GET['mensaje']) ?></div>
    <script>
        // Esperar 5 segundos, luego desvanecer el toast
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 1000); // eliminar del DOM después de animación
            }
        }, 5000);
    </script>
<?php endif; ?>

    <!-- ✅ Botón para agregar nuevo producto -->
    <a href="agregar_producto.php" class="agregar-btn" style="margin-bottom: 20px;">+ Agregar Producto</a>

    <!-- ✅ Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto): ?>
            <tr>
                <td><?= $producto['nombre'] ?></td>
                <td><?= $producto['tipo_producto'] ?></td>
                <td><?= $producto['precio_producto'] ?></td>
            <td>
                <a href="editar_producto.php?id=<?= $producto['id_producto'] ?>" class="editar-link">Editar</a> |
                <a href="../controllers/productosController.php?eliminar=<?= $producto['id_producto'] ?>" 
                onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                class="eliminar-link">Eliminar</a>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
