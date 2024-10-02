<?php
include('config.php');

$cardId = $_GET['cardId'];

$sql = "SELECT upright_meaning FROM tarot_cards WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cardId);
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();

echo json_encode(['meaning' => $card['upright_meaning']]);

$stmt->close();
$conn->close();
