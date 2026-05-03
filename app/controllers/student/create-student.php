<?php

include "../../../db/db.php";
include "../../../config/config.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}

if (
    !isset($_POST['name']) ||
    !isset($_POST['email']) ||
    !isset($_POST['course']) ||
    !isset($_FILES['profile_picture'])
){
    echo json_encode([
        "success" => false,
        "message" => "Name, Email, Course and Profile Picture must be provided"
    ]);
    exit;
}

$name = $_POST["name"];
$email = $_POST["email"];
$course = $_POST["course"];
$prof_pic = $_FILES['profile_picture'];

$file_extension = strtolower(pathinfo($prof_pic['name'], PATHINFO_EXTENSION));

if (!in_array($file_extension, ['jpg','jpeg','png'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid file extension"
    ]);
    exit;
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO student (full_name, email, course)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$name, $email, $course]);

    $student_id = $pdo->lastInsertId();

    $filename = $student_id . '.' . $file_extension;
    $full_path = STORAGE_DIR . '/' . $filename;

    if (!move_uploaded_file($prof_pic['tmp_name'], $full_path)) {
        throw new Exception("File upload failed");
    }

    $stmt = $pdo->prepare("
        UPDATE student
        SET profpic_path = ?
        WHERE id = ?
    ");

    $stmt->execute([$filename, $student_id]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Student successfully added"
    ]);

} catch (PDOException $err) {

    $pdo->rollBack();

    if ($err->getCode() == 19 || $err->getCode() == 23000) {
        echo json_encode([
            "success" => false,
            "error" => "DUPLICATE_EMAIL",
            "message" => "Email already in use"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database error"
        ]);
    }

} catch (Exception $e) {

    $pdo->rollBack();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}