<?php
include 'includes/db.php';

$id = $_GET['id'];
$query = "DELETE FROM students WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

header("Location: index.php");
?>
