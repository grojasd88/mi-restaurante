<?php
require_once(__DIR__ . '/../config/db.php');

// Obtener las mesas con sus estados desde la base de datos real
$sql = "SELECT numero_mesa AS numero, estado_mesa.estado_mesa AS estado
        FROM mesa
        JOIN estado_mesa ON mesa.id_estado_mesa = estado_mesa.id_estado_mesa
        ORDER BY numero_mesa ASC";
$stmt = $pdo->query($sql);
$mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para asignar clases CSS
function obtenerClaseEstado($estado) {
    return match (strtolower($estado)) {
        'ocupada' => 'mesa-ocupada',
        'reservada' => 'mesa-reservada',
        default => 'mesa-disponible',
    };
}
?>
