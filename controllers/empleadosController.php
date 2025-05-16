<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../models/empleados.php');

// AGREGAR EMPLEADO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);
    $id_nivel = $_POST['id_nivel'];

    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($contrasena)) {
        die("⚠️ Todos los campos son obligatorios.");
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("⚠️ El correo no es válido.");
    }

    if (!is_numeric($id_nivel)) {
        die("⚠️ Nivel inválido.");
    }

    // Hashear contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    if (agregarEmpleado($nombre, $apellido, $telefono, $correo, $contrasena_hash, $id_nivel)) {
        header("Location: ../views/ver_empleados.php?mensaje=Empleado+agregado");
        exit();
    } else {
        echo "❌ Error al agregar el empleado.";
    }
}

// EDITAR EMPLEADO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar'])) {
    $id_empleado = $_POST['id_empleado'];
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $id_nivel = $_POST['id_nivel'];

    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo)) {
        die("⚠️ Todos los campos son obligatorios.");
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("⚠️ El correo no es válido.");
    }

    if (!is_numeric($id_nivel)) {
        die("⚠️ Nivel inválido.");
    }

    if (editarEmpleado($id_empleado, $nombre, $apellido, $telefono, $correo, $id_nivel)) {
        header("Location: ../views/ver_empleados.php?mensaje=Empleado+actualizado");
        exit();
    } else {
        echo "❌ Error al actualizar el empleado.";
    }
}

// ELIMINAR EMPLEADO
if (isset($_GET['eliminar'])) {
    $id_empleado = $_GET['eliminar'];

    $sql = "DELETE FROM empleado WHERE id_empleado = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id_empleado])) {
        header("Location: ../views/ver_empleados.php?mensaje=Empleado+eliminado");
        exit();
    } else {
        echo "❌ Error al eliminar el empleado.";
    }
}
