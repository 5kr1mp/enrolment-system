<?php

include '../../db/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['subject_code'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Subject code is required.'
    ]);
    exit;
}

$subject_code = $input['subject_code'];
$subject_name = $input['subject_name'] ?? null;
$faculty_id = $input['faculty_id'] ?? null;
$day = $input['schedule_day'] ?? null;
$time_start = $input['time_start'] ?? null;
$time_end = $input['time_end'] ?? null;

try {

    $columns = [];
    $params = [':subject_code' => $subject_code];

    if ($subject_name !== null) {
        $columns[] = 'subject_name = :subject_name';
        $params[':subject_name'] = $subject_name;
    }

    if ($faculty_id !== null) {
        $columns[] = 'faculty_id = :faculty_id';
        $params[':faculty_id'] = $faculty_id;
    }

    if ($day !== null) {
        $columns[] = 'schedule_day = :schedule_day';
        $params[':schedule_day'] = $day;
    }

    if ($time_start !== null) {
        $columns[] = 'time_start = :time_start';
        $params[':time_start'] = $time_start;
    }

    if ($time_end !== null) {
        $columns[] = 'time_end = :time_end';
        $params[':time_end'] = $time_end;
    }

    if (empty($columns)) {
        echo json_encode([
            'success' => false,
            'message' => 'No fields to update.'
        ]);
        exit;
    }

    $query = 'UPDATE subject SET ' . implode(', ', $columns) . ' WHERE subject_code = :subject_code';

    $stmt = $pdo->prepare($query);

    $stmt->execute($params);

    echo json_encode([
        'success' => true,
        'message' => 'Subject updated successfully.',
        'updated_data' => $params
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}