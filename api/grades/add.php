<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $grade = $_POST['grade'];

    // Insert the new grade
    $sql = "INSERT INTO StudentGrades (student_id, subject_id, grade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $student_id, $subject_id, $grade);

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