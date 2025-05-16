<?php
require_once(__DIR__ . '/../config/db.php');

// Verifica si llega el ID correctamente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("⚠️ ID del producto no especificado.");
}

$id_producto = $_GET['id'];

// Obtener datos del producto
$query = "SELECT * FROM menu WHERE id_producto = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_producto]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die("❌ Producto no encontrado.");
}

// Obtener los tipos de productos
$queryTipos = "SELECT * FROM tipo_producto";
$stmtTipos = $pdo->query($queryTipos);
$tipos = $stmtTipos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Editar Producto</h2>
    <a href="ver_productos.php" style="display:inline-block; margin-bottom: 20px; text-decoration:none; background:#6c757d; color:white; padding:10px 15px; border-radius:5px;">← Volver a Productos</a>
    <form method="POST" action="../controllers/productosController.php">
        <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

        <label for="nombre">Nombre del producto:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required maxlength="100" pattern="[A-Za-z0-9\s]+" placeholder="">

        <label for="id_tipo_producto">Tipo de producto:</label>
        <select name="id_tipo_producto" id="id_tipo_producto" required>
            <option value="">Seleccione...</option>
            <?php foreach($tipos as $tipo): ?>
                <option value="<?= $tipo['id_tipo_producto'] ?>" <?= $producto['id_tipo_producto'] == $tipo['id_tipo_producto'] ? 'selected' : '' ?>>
                    <?= $tipo['tipo_producto'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="precio_producto">Precio:</label>
        <input type="number" name="precio_producto" id="precio_producto" value="<?= $producto['precio_producto'] ?>" step="0.01" min="0.01" required>

        <input type="submit" name="editar" value="Actualizar Producto">
    </form>
</body>
</html>
