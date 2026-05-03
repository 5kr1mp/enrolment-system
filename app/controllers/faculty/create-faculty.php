<?php
include "../../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (
    !isset($_POST['name']) ||
    !isset($_POST['email'])
){
    echo json_encode([
        "success"=>false,
        "message"=>"Name and Email must be provided."
    ]);
    exit;
}

$name = $_POST["name"];
$email = $_POST["email"];

try {
    $stmt = $pdo->prepare("INSERT INTO faculty (full_name,email) VALUES (?,?)");

    $stmt->execute([$name,$email]);
    echo json_encode([
        "success"=>true,
        "message"=>"Faculty successfully added"
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

?>