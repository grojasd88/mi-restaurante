<?php
require_once(__DIR__ . '/../config/db.php');

$query = "SELECT * FROM tipo_producto";
$stmt = $pdo->query($query);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
        <h2>Agregar Nuevo Producto</h2>
    <a href="ver_productos.php" style="display:inline-block; margin-bottom: 20px; text-decoration:none; background:#6c757d; color:white; padding:10px 15px; border-radius:5px;">← Volver a Productos</a>
    <form method="POST" action="../controllers/productosController.php">
        <label for="nombre">Nombre del producto:</label>
        <input type="text" name="nombre" id="nombre" required maxlength="100" pattern="[A-Za-z0-9\s]+" placeholder="">

        <label for="id_tipo_producto">Tipo de producto:</label>
        <select name="id_tipo_producto" id="id_tipo_producto" required>
            <option value="">Seleccione...</option>
            <?php foreach($tipos as $tipo): ?>
                <option value="<?= $tipo['id_tipo_producto'] ?>"><?= $tipo['tipo_producto'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="precio_producto">Precio:</label>
        <input type="number" name="precio_producto" id="precio_producto" step="0.01" min="0.01" required placeholder="">

        <input type="submit" name="agregar" value="Agregar Producto">
    </form>

<script>
    // Validación antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(event) {
        let nombre = document.querySelector('input[name="nombre"]').value;
        let precio = document.querySelector('input[name="precio_producto"]').value;
        let tipoProducto = document.querySelector('select[name="id_tipo_producto"]').value;

        // Validaciones
        if (nombre === "") {
            alert("El nombre del producto es obligatorio.");
            event.preventDefault();
            return false;
        }

        if (precio <= 0) {
            alert("El precio debe ser un número positivo.");
            event.preventDefault();
            return false;
        }

        if (tipoProducto === "") {
            alert("Selecciona un tipo de producto.");
            event.preventDefault();
            return false;
        }

        // Si todo es válido, el formulario se enviará.
        return true;
    });
</script>

</body>
</html>

