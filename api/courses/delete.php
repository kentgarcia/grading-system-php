<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Delete the course
    $sql = "DELETE FROM Courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Fetch all courses
        $result = $conn->query("SELECT c.id, c.title, yl.level_name, c.year_level_id
                                FROM Courses c
                                JOIN YearLevels yl ON c.year_level_id = yl.id");
        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $courses]);
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