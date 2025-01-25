<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Delete the grades associated with the student
    $sql = "DELETE FROM StudentGrades WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete the student
    $sql = "DELETE FROM Students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");

        // Fetch all students
        $result = $conn->query("SELECT s.id, s.first_name, s.last_name, s.age, s.avg_grade, c.title AS course_title, s.course_id
                                FROM Students s
                                JOIN Courses c ON s.course_id = c.id");
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $students]);
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