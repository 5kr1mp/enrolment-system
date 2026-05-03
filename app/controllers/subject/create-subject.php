<?php

include "../../../db/db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}

if (
    !isset($_POST['subject_code']) ||
    !isset($_POST['subject_name']) ||
    !isset($_POST['faculty_id']) ||
    !isset($_POST['schedule_day']) ||
    !isset($_POST['time_start']) ||
    !isset($_POST['time_end'])
){
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

$code = $_POST['subject_code'];
$name = $_POST['subject_name'];
$faculty_id = $_POST['faculty_id'];
$day = $_POST['schedule_day'];
$start = $_POST['time_start'];
$end = $_POST['time_end'];

try {
    $stmt = $pdo->prepare("
        INSERT INTO subject 
        (subject_code, subject_name, faculty_id, schedule_day, time_start, time_end)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $code,
        $name,
        $faculty_id,
        $day,
        $start,
        $end
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Subject successfully created"
    ]);

} catch (PDOException $e) {

    // duplicate subject_code (PRIMARY KEY)
    if ($e->getCode() == 19 || $e->getCode() == 23000) {
        echo json_encode([
            "success" => false,
            "error" => "DUPLICATE_SUBJECT_CODE",
            "message" => "Subject code already exists"
        ]);
        exit;
    }

    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}