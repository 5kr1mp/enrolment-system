<?php

include '../../db/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_GET['id'])){
    echo json_encode([
        "success" => false,
        "message" => "missing id"
    ]);
    exit;
}

$subject_code = $_GET['subject_code'];

try {

    $stmt = $pdo->prepare('DELETE FROM subject WHERE id = :id');

    $stmt->execute([":id"=>$subject_code]);

    if ($stmt->rowCount() === 0){
        echo json_encode([
            "success" => false,
            "message" => 
            "Faculty $subject_code not found"
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
