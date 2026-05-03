<?php

include "../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_GET['subject_code'])){
    echo json_encode([
        "success" => false,
        "message" => "missing id"
    ]);
    exit;
}

$subject_code = $_GET['subject_code'];

try {
    $stmt = $pdo->prepare("
        SELECT 
            s.subject_code,
            s.subject_name,
            f.full_name,
            s.schedule_day,
            s.time_start,
            s.time_end
        FROM subject AS s
        LEFT JOIN FACULTY as f ON f.id = s.faculty_id
        WHERE subject_code = ?
    ");

    $stmt->execute([$subject_code]);

    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

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