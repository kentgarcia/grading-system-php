<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $level_name = $_POST['level_name'];
    $curriculum_id = $_POST['curriculum_id'];

    // Insert the new year level
    $sql = "INSERT INTO YearLevels (level_name, curriculum_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $level_name, $curriculum_id);

    if ($stmt->execute()) {
        // Fetch all year levels
        $result = $conn->query("SELECT yl.id, yl.level_name, c.name AS curriculum_name, yl.curriculum_id
                                FROM YearLevels yl
                                JOIN Curriculums c ON yl.curriculum_id = c.id");
        $yearLevels = [];
        while ($row = $result->fetch_assoc()) {
            $yearLevels[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $yearLevels]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>