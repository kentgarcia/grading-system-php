<?php
include '../../db.php';

$sql = "SELECT s.id, s.first_name, s.last_name, s.age, s.avg_grade, 
                       CASE 
                           WHEN c.id IS NULL THEN 'N/A' 
                           ELSE c.title 
                       END AS course_title, 
                       s.course_id
                FROM Students s
                LEFT JOIN Courses c ON s.course_id = c.id";
$result = $conn->query($sql);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $students]);

$conn->close();
?>
