<?php
require_once(__DIR__ . '/../config/db.php');

// Leer el cuerpo JSON recibido (para AJAX)
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['numero'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Número de mesa no enviado']);
    exit;
}

$numero = (int) $input['numero'];

if ($numero === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'No se puede cambiar el estado de la mesa Domicilio']);
    exit;
}

// Obtener el estado actual
$sql = "SELECT m.id_mesa, e.id_estado_mesa, e.estado_mesa
        FROM mesa m
        JOIN estado_mesa e ON m.id_estado_mesa = e.id_estado_mesa
        WHERE m.numero_mesa = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$numero]);
$mesa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mesa) {
    http_response_code(404);
    echo json_encode(['error' => 'Mesa no encontrada']);
    exit;
}

$estados = ['disponible', 'reservada', 'ocupada'];
$actual = strtolower($mesa['estado_mesa']);
$indice = array_search($actual, $estados);
$nuevo_estado = $estados[($indice + 1) % count($estados)];

// Obtener ID del nuevo estado
$sql = "SELECT id_estado_mesa FROM estado_mesa WHERE estado_mesa = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nuevo_estado]);
$id_nuevo_estado = $stmt->fetchColumn();

// Actualizar mesa
$sql = "UPDATE mesa SET id_estado_mesa = ? WHERE numero_mesa = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_nuevo_estado, $numero]);

// Responder con el nuevo estado
echo json_encode(['estado' => $nuevo_estado]);
exit;
