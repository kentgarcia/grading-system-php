<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $code = $_POST['code'];
    $course_id = $_POST['course_id'];

    // Update the subject
    $sql = "UPDATE Subjects SET title = ?, code = ?, course_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $title, $code, $course_id, $id);

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