<?php

include "../../../db/db.php";

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

$student_id = $_GET['student_id'];

try {
    $stmt = $pdo->prepare("
        SELECT 
            s.subject_code,
            s.subject_name,
            f.full_name,
            s.schedule_day,
            s.time_start,
            s.time_end
        FROM subject as s
        INNER JOIN enrollment as e ON e.subject_code = s.subject_code
        INNER JOIN faculty as f ON f.id = s.faculty_id
        WHERE e.student_id = ?  
    ");

    $stmt->execute([$student_id]);

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
?>