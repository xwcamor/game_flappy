<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;
$conn = new mysqli('localhost', 'root', '1234', 'flappybird');
$user_id = $_SESSION['user_id'];
$score = intval($_POST['score']);
$stmt = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $score);
$stmt->execute();
?>