<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Disable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Delete the grades associated with the subject
    $sql = "DELETE FROM StudentGrades WHERE subject_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete the subject
    $sql = "DELETE FROM Subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");

        // Fetch all subjects
        $result = $conn->query("SELECT s.id, s.title, s.code, c.title AS course_title, s.course_id
                                FROM Subjects s
                                JOIN Courses c ON s.course_id = c.id");
        $subjects = [];
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $subjects]);
    } else {
        // Enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");

        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>