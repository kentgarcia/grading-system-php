<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $course_id = $_POST['course_id'];

    // Insert the new student
    $sql = "INSERT INTO Students (first_name, last_name, age, course_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $first_name, $last_name, $age, $course_id);

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