<?php

include "../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_GET['student_id'])){
    echo json_encode([
        "success" => false,
        "message" => "missing id"
    ]);
    exit;
}

$studentId = $_GET['student_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");

    $stmt->execute([$studentId]);

    $rows = $stmt->fetch(PDO::FETCH_OBJ);

    echo json_encode([
        "success" => true,
        "data" => $rows
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}
?>