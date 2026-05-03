<?php

include "../../../db/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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
    // Prepare the SQL statement to delete the faculty
    $stmt = $pdo->prepare('DELETE FROM student WHERE id = :id');

    $stmt->execute([":id"=>$studentId]);

    if ($stmt->rowCount() === 0){
        echo json_encode([
            "success" => false,
            "message" => 
            "Student $studentId not found"
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => 
            "Student deleted successfully."
        ]);
    }
      
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
