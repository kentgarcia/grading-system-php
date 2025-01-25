<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $code = $_POST['code'];
    $course_id = $_POST['course_id'];

    // Insert the new subject
    $sql = "INSERT INTO Subjects (title, code, course_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $code, $course_id);

    if ($stmt->execute()) {
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
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>