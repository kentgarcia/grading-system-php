<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_active = 1; // Automatically set to active

    // Call the stored procedure to add the curriculum
    $stmt = $conn->prepare("CALL AddCurriculum(?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $start_date, $end_date, $is_active);

    if ($stmt->execute()) {
        // Fetch all curriculums
        $result = $conn->query("CALL GetCurriculums()");
        $curriculums = [];
        while ($row = $result->fetch_assoc()) {
            $curriculums[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $curriculums]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>