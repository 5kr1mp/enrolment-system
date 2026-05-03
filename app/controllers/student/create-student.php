<?php
include "../../db/db.php";
include '../../config/config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (
    !isset($_POST['name']) ||
    !isset($_POST['email']) ||
    !isset($_POST['course']) ||
    !isset($_FILES['profile_picture'])
){
    echo json_encode([
        "success"=>false,
        "message"=>"Name, Email, Course and Profile Picture must be provided"
    ]);    
}

$name = $_POST("name");
$email = $_POST("email");
$course = $_POST('course');
$prof_pic = $_FILES('profile_picture');

$file_extension = strtolower(pathinfo($prof_pic['name'], PATHINFO_EXTENSION));
// validate file extension
if (!in_array($file_extension,['jpg','jpeg','png'])){
    echo json_encode([
        "success"=>false,
        "message"=>"Invalid File Extension"
    ]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO student (full_name,email,course) VALUES (?,?,?)");

try {
    $stmt->execute([$name,$email,$course]);
    echo json_encode([
        "success"=>true,
        "message"=>"Student successfully added"
    ]);
} catch (PDOException $err){
    if ($err->getCode() == 19 || $err->getCode() == 23000){
        echo json_encode([
            "success"=>false,
            "error"=>"DUPLICATE_EMAIL",
            "message"=>"Email: $email already in use"
        ]);
        exit;
    } else {
        echo json_encode([
            "success"=>false,
            "message"=>"Something went wrong"
        ]);
    }
}

// now to the file stuff
$student_id = $pdo->lastInsertId();
$filename = $student_id.'.'.$file_extension;
$full_filename=STORAGE_DIR.'/'.$filename;
move_uploaded_file($prof_pic['tmp_name'], $full_filename);

$stmt = $pdo->prepare("
    UPDATE students
    SET profile_picture = ?
    WHERE id = ?
");

$stmt->execute([$filename,$student_id]);

?>