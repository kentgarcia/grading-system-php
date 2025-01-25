<?php
include '../../db.php';

header('Content-Type: application/json'); // Ensure the response is JSON

// Fetch functions
$functionsSql = "SELECT ROUTINE_NAME, ROUTINE_TYPE, CREATED, LAST_ALTERED 
                 FROM INFORMATION_SCHEMA.ROUTINES 
                 WHERE ROUTINE_TYPE = 'FUNCTION' AND ROUTINE_SCHEMA = DATABASE()";
$functionsResult = $conn->query($functionsSql);

$functions = [];
while ($row = $functionsResult->fetch_assoc()) {
    $functions[] = $row;
}

// Fetch procedures
$proceduresSql = "SELECT ROUTINE_NAME, ROUTINE_TYPE, CREATED, LAST_ALTERED 
                  FROM INFORMATION_SCHEMA.ROUTINES 
                  WHERE ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_SCHEMA = DATABASE()";
$proceduresResult = $conn->query($proceduresSql);

$procedures = [];
while ($row = $proceduresResult->fetch_assoc()) {
    $procedures[] = $row;
}

// Fetch triggers
$triggersSql = "SELECT TRIGGER_NAME, EVENT_MANIPULATION, EVENT_OBJECT_TABLE, ACTION_STATEMENT, CREATED 
                FROM INFORMATION_SCHEMA.TRIGGERS 
                WHERE TRIGGER_SCHEMA = DATABASE()";
$triggersResult = $conn->query($triggersSql);

$triggers = [];
while ($row = $triggersResult->fetch_assoc()) {
    $triggers[] = $row;
}

echo json_encode(['status' => 'success', 'data' => ['functions' => $functions, 'procedures' => $procedures, 'triggers' => $triggers]]);

$conn->close();
?>