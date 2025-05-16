<?php
require_once(__DIR__ . '/../config/db.php');

function agregarEmpleado($nombre, $apellido, $telefono, $correo, $contrasena, $id_nivel) {
    global $pdo;
    $sql = "INSERT INTO empleado (nombre, apellido, telefono, correo, contrasena, id_nivel)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $apellido, $telefono, $correo, $contrasena, $id_nivel]);
}

function editarEmpleado($id_empleado, $nombre, $apellido, $telefono, $correo, $id_nivel) {
    global $pdo;
    $sql = "UPDATE empleado SET nombre = ?, apellido = ?, telefono = ?, correo = ?, id_nivel = ? 
            WHERE id_empleado = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $apellido, $telefono, $correo, $id_nivel, $id_empleado]);
}

function eliminarEmpleado($id_empleado) {
    global $pdo;
    $sql = "DELETE FROM empleado WHERE id_empleado = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_empleado]);
}
