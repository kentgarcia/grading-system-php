<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $year_level_id = $_POST['year_level_id'];

    // Insert the new course
    $sql = "INSERT INTO Courses (title, year_level_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $title, $year_level_id);

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
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>