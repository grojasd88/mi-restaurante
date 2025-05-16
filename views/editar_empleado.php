<?php
require_once(__DIR__ . '/../config/db.php');

if (!isset($_GET['id'])) {
    die("⚠️ ID de empleado no especificado.");
}

$id_empleado = $_GET['id'];

// Obtener info del empleado
$stmt = $pdo->prepare("SELECT * FROM empleado WHERE id_empleado = ?");
$stmt->execute([$id_empleado]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    die("⚠️ Empleado no encontrado.");
}

// Obtener niveles
$niveles = $pdo->query("SELECT * FROM nivel")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<h2>Editar Empleado</h2>

<form action="../controllers/empleadosController.php" method="POST">
    <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($empleado['nombre']) ?>" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?= htmlspecialchars($empleado['apellido']) ?>" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($empleado['telefono']) ?>" required>

    <label for="correo">Correo:</label>
    <input type="text" name="correo" value="<?= htmlspecialchars($empleado['correo']) ?>" required>

    <label for="id_nivel">Nivel:</label>
    <select name="id_nivel" required>
    <?php foreach ($niveles as $nivel): ?>
        <option value="<?= $nivel['id_nivel'] ?>" <?= $nivel['id_nivel'] == $empleado['id_nivel'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($nivel['nivel']) ?>
        </option>
    <?php endforeach; ?>
    </select>

    <input type="submit" name="editar" value="Actualizar Empleado">
</form>

</body>
</html>
