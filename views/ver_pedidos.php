<?php
// Obtener el número de mesa desde la URL
$numero_mesa = isset($_GET['mesa']) ? (int)$_GET['mesa'] : 0;

// Validación mínima
if ($numero_mesa === 0) {
    echo "<h2>Mesa no válida.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido Mesa <?= $numero_mesa ?></title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Ajusta si es necesario -->
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }
        .formulario {
            max-width: 500px;
            margin: auto;
        }
        .formulario h2 {
            text-align: center;
        }
        .formulario input, .formulario select, .formulario button {
            display: block;
            width: 100%;
            margin: 12px 0;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="formulario">
        <h2>Pedido - Mesa <?= $numero_mesa ?></h2>
        <form action="guardar_pedido.php" method="POST">
            <input type="hidden" name="mesa" value="<?= $numero_mesa ?>">

            <label for="producto">Producto:</label>
            <input type="text" name="producto" id="producto" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" value="1" min="1" required>

            <button type="submit">Agregar al pedido</button>
        </form>
    </div>
</body>
</html>
