<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Delete the year level
    $sql = "DELETE FROM YearLevels WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

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
        $conn->query("SET FOREIGN_KEY_CHECKS=1");

        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>