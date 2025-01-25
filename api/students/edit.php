<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $course_id = $_POST['course_id'];

    // Update the student
    $sql = "UPDATE Students SET first_name = ?, last_name = ?, age = ?, course_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $first_name, $last_name, $age, $course_id, $id);

    if ($stmt->execute()) {
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
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>