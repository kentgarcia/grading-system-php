<?php
include '../../db.php';

header('Content-Type: application/json'); // Ensure the response is JSON

$data = json_decode(file_get_contents('php://input'), true);
$studentId = $data['studentId'];
$subjectId = $data['subjectId'];

$sql = "SELECT COUNT(*) AS count FROM StudentGrades WHERE student_id = ? AND subject_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $studentId, $subjectId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}

$stmt->close();
$conn->close();
?>