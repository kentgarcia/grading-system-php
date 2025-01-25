<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    // Fetch student details
    $sql = "SELECT s.id, s.first_name, s.last_name, s.age, s.avg_grade, 
                   CASE 
                       WHEN c.id IS NULL THEN 'N/A' 
                       ELSE c.title 
                   END AS course_title, 
                   s.course_id
            FROM Students s
            LEFT JOIN Courses c ON s.course_id = c.id
            WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    // Fetch student grades
    $sql = "SELECT sg.id, sub.title AS subject_title, sg.grade
            FROM StudentGrades sg
            JOIN Subjects sub ON sg.subject_id = sub.id
            WHERE sg.student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $grades = [];
    while ($row = $result->fetch_assoc()) {
        $grades[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => ['student' => $student, 'grades' => $grades]]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>