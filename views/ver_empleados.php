<?php
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM vista_empleados");
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Empleados</h2>
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

    <!-- ✅ Mensaje si no hay empleados -->
    <?php if (empty($empleados)): ?>
        <div class="mensaje">No hay empleados registrados.</div>
    <?php else: ?>

    <!-- ✅ Botón para agregar nuevo empleado -->
    <a href="agregar_empleado.php" class="agregar-btn" style="margin-bottom: 20px;">+ Agregar Empleado</a>

    <!-- ✅ Tabla de empleados -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $emp): ?>
            <tr>
                <td><?= htmlspecialchars($emp['id_empleado']) ?></td>
                <td><?= htmlspecialchars($emp['nombre']) ?></td>
                <td><?= htmlspecialchars($emp['apellido']) ?></td>
                <td><?= htmlspecialchars($emp['telefono']) ?></td>
                <td><?= htmlspecialchars($emp['correo']) ?></td>
                <td><?= htmlspecialchars($emp['nivel']) ?></td>
        <td>
            <a href="editar_empleado.php?id=<?= $emp['id_empleado'] ?>" class="editar-link">Editar</a> |
            <a href="../controllers/empleadosController.php?eliminar=<?= $emp['id_empleado'] ?>" 
            onclick="return confirm('¿Estás seguro de eliminar este empleado?')" 
            class="eliminar-link">Eliminar</a>
        </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>
</body>
</html>
