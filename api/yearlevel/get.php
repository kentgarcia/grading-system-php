<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all year levels with curriculum status
    $sql = "SELECT yl.id, yl.level_name, 
                   CASE 
                       WHEN c.id IS NULL THEN 'DELETED CURRICULUM' 
                       ELSE c.name 
                   END AS curriculum_name
            FROM yearlevels yl
            LEFT JOIN curriculums c ON yl.curriculum_id = c.id";
    $result = $conn->query($sql);
    $yearlevels = [];
    while ($row = $result->fetch_assoc()) {
        $yearlevels[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $yearlevels]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>