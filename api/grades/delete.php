<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Delete the grade
    $sql = "DELETE FROM StudentGrades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Fetch all grades
        $result = $conn->query("SELECT sg.id, s.first_name, s.last_name, sub.title AS subject_title, sg.grade
                                FROM StudentGrades sg
                                JOIN Students s ON sg.student_id = s.id
                                JOIN Subjects sub ON sg.subject_id = sub.id");
        $grades = [];
        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $grades]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>