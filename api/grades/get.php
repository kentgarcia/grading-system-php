<?php
include '../../db.php';

$sql = "SELECT sg.id, sg.student_id, sg.subject_id, sg.grade, 
               s.first_name, s.last_name, 
               sub.title AS subject_title
        FROM StudentGrades sg
        JOIN Students s ON sg.student_id = s.id
        JOIN Subjects sub ON sg.subject_id = sub.id";
$result = $conn->query($sql);

$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $grades]);

$conn->close();
?>