<?php
require_once(__DIR__ . '/../config/db.php');

// Obtener niveles para el select
$stmt = $pdo->query("SELECT * FROM nivel");
$niveles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

    <h2>Agregar Nuevo Empleado</h2>

    <!-- Botón volver -->
    <a href="ver_empleados.php" style="display:inline-block; margin-bottom: 20px; text-decoration:none; background:#6c757d; color:white; padding:10px 15px; border-radius:5px;">← Volver a Empleados</a>

    <!-- Mensaje si viene en la URL -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje-exito" style="background: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;">
            <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form method="POST" action="../controllers/empleadosController.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required maxlength="100" pattern="[A-Za-z\s]+" title="Solo letras y espacios">

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required maxlength="100" pattern="[A-Za-z\s]+">

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required maxlength="15" pattern="[0-9]+">

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required maxlength="100">

        <label for="contrasena">Contraseña:</label>
        <div class="password-container">
             <input type="password" name="contrasena" id="contrasena" required maxlength="255" placeholder="">
        <span id="toggleIcon" onclick="togglePassword()">👁️</span>
        </div>

        <label for="id_nivel">Nivel:</label>
        <select name="id_nivel" id="id_nivel" required>
            <option value="">-- Selecciona un nivel --</option>
            <?php foreach ($niveles as $nivel): ?>
                <option value="<?= $nivel['id_nivel'] ?>"><?= htmlspecialchars($nivel['nivel']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="agregar" value="Agregar Empleado">
    </form>

    <!-- Validación JS opcional -->
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const correo = document.getElementById('correo').value.trim();
            const contrasena = document.getElementById('contrasena').value.trim();
            const nivel = document.getElementById('id_nivel').value;

            if (!nombre || !apellido || !telefono || !correo || !contrasena || !nivel) {
                alert("Todos los campos son obligatorios.");
                event.preventDefault();
            }
        });
    </script>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        function togglePassword() {
            const input = document.getElementById('contrasena');
            const icon = document.getElementById('toggleIcon');
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            icon.textContent = isPassword ? '🙈' : '👁️';
        }
    </script>

</body>
</html>
