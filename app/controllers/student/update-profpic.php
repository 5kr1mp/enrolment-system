<?php

include '../../db/db.php';
include '../../config/config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

if (
    !isset($_POST['student_id']) ||
    !isset($_FILES['profpic'])
) {
    echo json_encode([
        "success" => false,
        "message" => "Student ID and profile picture are required"
    ]);
    exit;
}

$student_id = $_POST['student_id'];
$file = $_FILES['profpic'];

try {

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error");
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid file type. Only JPG, JPEG, PNG allowed."
        ]);
        exit;
    }

    $filename = $student_id . "." . $ext;
    $uploadPath = STORAGE_DIR;
    $fullPath = $uploadPath . "/" . $filename;

    if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
        throw new Exception("Failed to save file");
    }

    $stmt = $pdo->prepare("
        UPDATE student 
        SET profpic_path = :path 
        WHERE id = :id
    ");

    $stmt->execute([
        ":path" => $filename,
        ":id" => $student_id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Profile picture updated successfully",
        "file" => $filename
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}