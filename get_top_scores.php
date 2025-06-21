<?php
header('Content-Type: application/json');

// Conexión directa a la base de datos
$mysqli = new mysqli("localhost", "root", "1234", "flappybird");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión']);
    exit;
}

// Consulta para obtener los 3 mejores puntajes
$query = "
    SELECT u.username, MAX(s.score) AS score 
    FROM scores s
    JOIN users u ON s.user_id = u.id
    GROUP BY s.user_id
    ORDER BY score DESC
    LIMIT 3
";

$result = $mysqli->query($query);

$topScores = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $topScores[] = $row;
    }
    echo json_encode($topScores);
} else {
    echo json_encode(['error' => 'Error en la consulta']);
}

$mysqli->close();
?>
