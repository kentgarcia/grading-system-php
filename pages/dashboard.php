<?php
include './db.php';

// Fetch counts from the database
$studentCount = $conn->query("SELECT COUNT(*) AS count FROM Students")->fetch_assoc()['count'];
$subjectCount = $conn->query("SELECT COUNT(*) AS count FROM Subjects")->fetch_assoc()['count'];
$courseCount = $conn->query("SELECT COUNT(*) AS count FROM Courses")->fetch_assoc()['count'];
$curriculumCount = $conn->query("SELECT COUNT(*) AS count FROM Curriculums")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">


        <!-- Students -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-red text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $studentCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Subjects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $subjectCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $courseCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Curriculums -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Curriculums</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $curriculumCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-scroll fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Logs Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Logs</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="logsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Logs will be dynamically populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Routines and Triggers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Functions, Procedures, and Triggers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="routinesAndTriggersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Event</th>
                            <th>Table</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Routines and Triggers will be dynamically populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            var listTable = $('#routinesAndTriggersTable').DataTable();

            function fetchRoutinesAndTriggers() {
                $.ajax({
                    type: 'GET',
                    url: 'api/logs/get_routines_and_triggers.php',
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {

                            if (response.status === 'success') {
                                // Clear the table
                                listTable.clear();

                                // Add functions
                                response.data.functions.forEach(function (func) {
                                    listTable.row.add([
                                        func.ROUTINE_NAME,
                                        func.ROUTINE_TYPE,
                                        '',
                                        '',
                                        ''
                                    ]).draw();
                                });

                                // Add procedures
                                response.data.procedures.forEach(function (proc) {
                                    listTable.row.add([
                                        proc.ROUTINE_NAME,
                                        proc.ROUTINE_TYPE,
                                        '',
                                        '',
                                        ''
                                    ]).draw();
                                });

                                // Add triggers
                                response.data.triggers.forEach(function (trigger) {
                                    listTable.row.add([
                                        trigger.TRIGGER_NAME,
                                        'TRIGGER',
                                        trigger.EVENT_MANIPULATION,
                                        trigger.EVENT_OBJECT_TABLE,
                                        trigger.ACTION_STATEMENT
                                    ]).draw();
                                });
                            } else {
                                console.error('Failed to fetch routines and triggers.');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }
                    },
                    error: function () {
                        console.error('Failed to fetch routines and triggers.');
                    }
                });
            }

            // Fetch routines and triggers on page load
            fetchRoutinesAndTriggers();
            var table = $('#logsTable').DataTable();

            function fetchLogs() {
                $.ajax({
                    type: 'GET',
                    url: 'api/logs/get.php',
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            // Clear the table
                            table.clear();

                            // Add the new data to the table
                            result.data.forEach(function (log) {
                                table.row.add([
                                    log.id,
                                    log.action,
                                    log.timestamp
                                ]).draw();
                            });
                        } else {
                            console.error('Failed to fetch logs.');
                        }
                    },
                    error: function () {
                        console.error('Failed to fetch logs.');
                    }
                });
            }

            // Fetch logs on page load
            fetchLogs();
        });
    </script>
</body>

</html>