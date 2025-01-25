<?php
include '../../db.php';

header('Content-Type: application/json'); // Ensure the response is JSON

$sql = "SELECT c.id, c.title, 
               CASE 
                   WHEN yl.id IS NULL THEN 'DELETED YEAR LEVEL' 
                   ELSE yl.level_name 
               END AS level_name
        FROM Courses c
        LEFT JOIN yearlevels yl ON c.year_level_id = yl.id";
$result = $conn->query($sql);

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $courses]);

$conn->close();
?>