<?php
$cardId = $_GET['cardId'];
$conn = new mysqli('localhost', 'username', 'password', 'tarot_db');

$query = "SELECT upright_meaning FROM tarot_cards WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cardId);
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();

echo json_encode(['meaning' => $card['upright_meaning']]);
