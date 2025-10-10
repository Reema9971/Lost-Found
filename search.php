<?php
require_once 'includes/config.php';

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM items WHERE title LIKE ? OR description LIKE ?");
$stmt->execute(["%$search%", "%$search%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Display results similar to items.php -->