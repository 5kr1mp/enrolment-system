<?php
    include "../../../db/db.php";

    header("Content-Type: application/json");


    $student_id = $_POST['student_id'];
    $subject_codes = $_POST['subjects'];

    // input validation

    if (!$student_id || !$subject_codes){
        echo json_encode([
            "success" => false,
            "message" => "Student ID and subjects are required"
        ]);
        exit;
    }

    // run
    $inserted = [];
    $ignored = [];
    $stmt = $pdo->prepare("
        INSERT INTO OR IGNORE enrollment(student_id,subject_code)
        VALUES (:student_id,:subject_code)
    ");

    foreach ($subject_codes as $subject){
        try {
            $stmt->execute([
                ":student_id"=> $student_id,
                ":subject_code"=> $subject
            ]);
    
            $inserted[] = $subject;

        } catch (PDOException $err){
            if ($err->getCode() == 23000 || $err->getCode() == 19){
                $ignored[] = $subject;
            }
        }
    }

    echo json_encode([
        "success" => true,
        "student_id" => $student_id,
        "enrolled" => $inserted,
        "skipped" => $ignored,
        "message" => "Successfully enrolled in ".count($inserted)." subjects"
    ])
?>