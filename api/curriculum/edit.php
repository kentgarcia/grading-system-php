<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_active = $_POST['is_active'];

    // Call the stored procedure to edit the curriculum
    $stmt = $conn->prepare("CALL EditCurriculum(?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $id, $name, $start_date, $end_date, $is_active);

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