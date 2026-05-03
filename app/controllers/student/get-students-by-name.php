<?php

include "../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}

if (!isset($_GET['name'])) {
    echo json_encode([
        "success" => false,
        "message" => "missing name"
    ]);
    exit;
}

$name = $_GET['name'];

try {

    $stmt = $pdo->prepare("
        SELECT * 
        FROM student 
        WHERE full_name LIKE ?
    ");

    $stmt->execute(["%$name%"]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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