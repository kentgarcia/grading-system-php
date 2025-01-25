<?php
include '../../db.php';

header('Content-Type: application/json'); // Ensure the response is JSON

$sql = "SELECT s.id, s.title, s.code, 
               CASE 
                   WHEN c.id IS NULL THEN 'DELETED COURSE' 
                   ELSE c.title 
               END AS course_title,
               CASE 
                   WHEN yl.id IS NULL THEN 'DELETED YEAR LEVEL' 
                   ELSE yl.level_name 
               END AS level_name,
               s.course_id
        FROM Subjects s
        LEFT JOIN Courses c ON s.course_id = c.id
        LEFT JOIN YearLevels yl ON c.year_level_id = yl.id";
$result = $conn->query($sql);

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $subjects]);

$conn->close();
?>