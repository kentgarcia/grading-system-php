<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Disable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Call the stored procedure to delete the curriculum
    $stmt = $conn->prepare("CALL DeleteCurriculum(?)");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Fetch all curriculums
        $result = $conn->query("CALL GetCurriculums()");
        $curriculums = [];
        while ($row = $result->fetch_assoc()) {
            $curriculums[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $curriculums]);
    } else {

        // Enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>