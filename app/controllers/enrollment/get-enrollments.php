<?php

include "../../db/db.php";

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
            st.id AS student_id,
            st.full_name,
            st.profpic_path,
            
            s.subject_code,
            s.subject_name,
            s.schedule_day,
            s.time_start,
            s.time_end,
            
            f.full_name AS faculty_name

        FROM student st
        LEFT JOIN enrollment e ON e.student_id = st.id
        LEFT JOIN subject s ON s.subject_code = e.subject_code
        LEFT JOIN faculty f ON f.id = s.faculty_id
        WHERE st.id = ?
        ORDER BY st.id;
    ");

    $stmt->execute([$student_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $student = [
        "student_id" => null,
        "full_name" => null,
        "profpic_path" => null,
        "subjects" => []
    ];

    $data = [];

$students = [];
$student = null;

    foreach ($rows as $row) {

        if ($student === null) {
            $student = [
                "student_id" => $row["student_id"],
                "full_name" => $row["full_name"],
                "profpic_path" => $row["profpic_path"],
                "subjects" => []
            ];
        }

        // if a different student, save the previous one in $students[]
        if ($row["student_id"] != $student["student_id"]) {
            $students[] = $student;

            $student = [
                "student_id" => $row["student_id"],
                "full_name" => $row["full_name"],
                "profpic_path" => $row["profpic_path"],
                "subjects" => []
            ];
        }

        // add subject
        if ($row["subject_code"]) {
            $student["subjects"][] = [
                "subject_code" => $row["subject_code"],
                "subject_name" => $row["subject_name"],
                "faculty" => $row["faculty_name"],
                "day" => $row["schedule_day"],
                "time_start" => $row["time_start"],
                "time_end" => $row["time_end"]
            ];
        }
    }

    if ($student !== null) {
        $students[] = $student;
    }

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