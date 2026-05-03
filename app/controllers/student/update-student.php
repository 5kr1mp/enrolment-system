<?php

include '../../db/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (
    !isset($input['student_id']) || 
    (
        !isset($input['name']) && 
        !isset($input['email']) && 
        !isset($input['course'])
    )
    ) {
    echo json_encode(['success' => false, 'message' => 'Faculty ID and at least one field are required.']);
    exit;
}

$studentId = $input['student_id'];
$fullName = $input['name'] ?? null;
$email = $input['email'] ?? null;

try {
    $colunms = [];
    $params = [':id' => $studentId];

    if ($fullName !== null) {
        $colunms[] = 'full_name = :name';
        $params[':name'] = $fullName;
    }

    if ($email !== null) {
        $colunms[] = 'email = :email';
        $params[':email'] = $email;
    }

    $query = 'UPDATE faculty SET ' . implode(', ', $colunms) . ' WHERE id = :id';
    $stmt = $pdo->prepare($query);

    if ($stmt->execute($params)) {
        echo json_encode([
            'success' => true,
            'message' => 'Faculty updated successfully.',
            'updated_data' => $params
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Failed to update faculty.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

?>