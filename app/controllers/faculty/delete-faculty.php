<?php

include '../../db/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

    $stmt = $pdo->prepare('DELETE FROM faculty WHERE id = :id');

    $stmt->execute([":id"=>$facultyId]);

    if ($stmt->rowCount() === 0){
        echo json_encode([
            "success" => false,
            "message" => 
            "Faculty $facultyId not found"
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => 
            "Faculty deleted successfully."
        ]);
    }
      
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
