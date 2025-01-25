<?php
include '../../db.php';

$sql = "SELECT id, action, timestamp FROM Logs ORDER BY timestamp DESC";
$result = $conn->query($sql);

$logs = [];
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $logs]);

$conn->close();
?>