<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$mysqli = new mysqli("localhost", "root", "1234", "flappybird");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT MAX(score) AS best_score FROM scores WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($best_score);
$stmt->fetch();
$stmt->close();
$mysqli->close();

echo json_encode(['best_score' => $best_score ?? 0]);
?>
