<?php
include './db.php';

// Fetch curriculums from the database
$sql = "SELECT id, name FROM Curriculums";
$result = $conn->query($sql);

// Fetch all results from the query
$curriculums = [];
while ($row = $result->fetch_assoc()) {
    $curriculums[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Year Levels Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Year Level</h1>
            <p class="mb-4">This page is used to manage year levels.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Subjects Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addYearLevelModal">Add
                                New
                                Year Level</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="yearLevelsTable">
                            <thead>
                                <tr>
                                    <th>Level Name</th>
                                    <th>Curriculum</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Year levels will be dynamically populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>

    <!-- Add Year Level Modal -->
    <div class="modal fade" id="addYearLevelModal" tabindex="-1" aria-labelledby="addYearLevelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addYearLevelModalLabel">Add New Year Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addYearLevelForm">
                        <div class="mb-3">
                            <label for="level_name" class="form-label">Level Name</label>
                            <input type="text" class="form-control" id="level_name" name="level_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="curriculum_id" class="form-label">Curriculum</label>
                            <select class="form-select" id="curriculum_id" name="curriculum_id" required>
                                <?php foreach ($curriculums as $curriculum): ?>
                                    <option value="<?= $curriculum['id'] ?>"><?= $curriculum['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Add Year Level</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Year Level Modal -->
    <div class="modal fade" id="editYearLevelModal" tabindex="-1" aria-labelledby="editYearLevelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editYearLevelModalLabel">Edit Year Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editYearLevelForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_level_name" class="form-label">Level Name</label>
                            <input type="text" class="form-control" id="edit_level_name" name="level_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_curriculum_id" class="form-label">Curriculum</label>
                            <select class="form-select" id="edit_curriculum_id" name="curriculum_id" required>
                                <?php foreach ($curriculums as $curriculum): ?>
                                    <option value="<?= $curriculum['id'] ?>"><?= $curriculum['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Year Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this year level?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorModalBody">
                    <!-- Error message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
            var table = $('#yearLevelsTable').DataTable();

            $('#addYearLevelForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/yearlevel/add.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#addYearLevelModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Year Level added successfully!');
                            $('.modal-backdrop').remove();
                            // Optionally, fetch and update the table with the new year level
                            fetchYearLevels();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Year Level.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Year Level.');
                    }
                });
            });

            function fetchYearLevels() {
                $.ajax({
                    type: 'GET',
                    url: 'api/yearlevel/get.php',
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                // Clear the table
                                table.clear();

                                // Add the new data to the table
                                result.data.forEach(function (yearlevel) {
                                    table.row.add([
                                        yearlevel.level_name,
                                        yearlevel.curriculum_name,
                                        '<button class="btn btn-warning btn-sm edit-btn" data-id="' + yearlevel.id + '" data-level_name="' + yearlevel.level_name + '" data-curriculum_id="' + yearlevel.curriculum_id + '">Edit</button> ' +
                                        '<button class="btn btn-danger btn-sm delete-btn" data-id="' + yearlevel.id + '">Delete</button>'
                                    ]).draw();
                                });
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to retrieve year levels.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to retrieve year levels.');
                        $('#errorModal').modal('show');
                    }
                });
            }

            // Fetch year levels on page load
            fetchYearLevels();

            // Edit year level
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var level_name = $(this).data('level_name');
                var curriculum_id = $(this).data('curriculum_id');

                $('#edit_id').val(id);
                $('#edit_level_name').val(level_name);
                $('#edit_curriculum_id').val(curriculum_id);

                $('#editYearLevelModal').modal('show');
            });

            $('#editYearLevelForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/yearlevel/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#editYearLevelModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Year Level updated successfully!');
                            fetchYearLevels();
                        } else {
                            $('#errorModalBody').text(result.message);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to update Year Level.');
                        $('#errorModal').modal('show');
                    }
                });
            });

            // Delete year level
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/yearlevel/delete.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Year Level deleted successfully!');
                                fetchYearLevels();
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Year Level.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Year Level.');
                        $('#errorModal').modal('show');
                    }
                });

            });
        });
    </script>
</body>

</html>