<?php
require_once '../config/db.php';

// Obtener tipos de promoción y productos disponibles
$stmtPromo = $pdo->query("SELECT * FROM tipo_promo");
$promos = $stmtPromo->fetchAll(PDO::FETCH_ASSOC);

$stmtProductos = $pdo->query("SELECT * FROM menu");
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Combo</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Crear Nuevo Combo</h2>
    <form action="../controllers/comboController.php" method="POST" onsubmit="return validarFormulario();">
        <label for="nombre">Nombre del Combo:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="tipo_promo">Tipo de Promoción:</label>
        <select name="tipo_promo" id="tipo_promo" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($promos as $promo): ?>
                <option value="<?= $promo['id_tipo_promo'] ?>"><?= htmlspecialchars($promo['tipo_promo']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio del Combo:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>

        <label for="descuento">Descuento (%):</label>
        <input type="number" step="0.01" name="descuento" id="descuento" value="0">

        <label for="producto">Producto:</label>
        <select id="producto">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($productos as $prod): ?>
                <option value="<?= $prod['id_producto'] ?>"><?= htmlspecialchars($prod['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" min="1">

        <button type="button" onclick="agregarProducto()">+ Agregar Producto</button>

        <ul id="productos-seleccionados"></ul>

        <input type="submit" value="Crear Combo">
    </form>

    <script>
    function agregarProducto() {
        const producto = document.getElementById('producto');
        const cantidad = document.getElementById('cantidad');

        if (!producto.value || !cantidad.value || cantidad.value <= 0) {
            alert('Seleccione un producto válido y cantidad mayor a 0');
            return;
        }

        const nombre = producto.options[producto.selectedIndex].text;
        const ul = document.getElementById('productos-seleccionados');

        // Crear elementos
        const li = document.createElement('li');
        li.textContent = nombre + ' - Cantidad: ' + cantidad.value;

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'productos[]';
        hidden.value = producto.value + ':' + cantidad.value;

        li.appendChild(hidden);
        ul.appendChild(li);

        // Reset
        producto.value = '';
        cantidad.value = '';
    }

    function validarFormulario() {
        const nombre = document.getElementById('nombre').value.trim();
        const precio = document.getElementById('precio').value;
        const productos = document.querySelectorAll('input[name="productos[]"]');

        if (nombre === '' || precio === '' || productos.length === 0) {
            alert('Complete todos los campos y agregue al menos un producto.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
