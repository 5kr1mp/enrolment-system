<?php

include "../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_GET['faculty_id'])){
    echo json_encode([
        "success" => false,
        "message" => "missing id"
    ]);
    exit;
}

$facultyId = $_GET['faculty_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM faculty WHERE id = ?");

    $stmt->execute([$facultyId]);

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