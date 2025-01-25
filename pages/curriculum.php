<?php
include './db.php';

// Fetch curriculums from the database
$sql = "SELECT * FROM Curriculums";
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
    <title>Curriculum Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Curriculum</h1>
            <p class="mb-4">This page shows the list of curriculums. You can add, edit, and delete curriculums here.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Curriculum Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div>
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addCurriculumModal">Add
                                New
                                Curriculum</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="curriculumsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($curriculums as $row): ?>
                                    <tr>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['start_date'] ?></td>
                                        <td><?= $row['end_date'] ?></td>
                                        <td><?= $row['is_active'] ? 'Active' : 'Inactive' ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $row['id'] ?>"
                                                data-name="<?= $row['name'] ?>" data-start_date="<?= $row['start_date'] ?>"
                                                data-end_date="<?= $row['end_date'] ?>"
                                                data-is_active="<?= $row['is_active'] ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?= $row['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        </div>
    </main>

    <!-- Add Curriculum Modal -->
    <div class="modal fade" id="addCurriculumModal" tabindex="-1" aria-labelledby="addCurriculumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCurriculumModalLabel">Add New Curriculum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCurriculumForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div id="dateError" class="alert alert-danger d-none" role="alert"></div>
                        <button type="submit" class="btn btn-red">Add Curriculum</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Curriculum Modal -->
    <div class="modal fade" id="editCurriculumModal" tabindex="-1" aria-labelledby="editCurriculumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCurriculumModalLabel">Edit Curriculum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCurriculumForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_is_active" class="form-label">Status</label>
                            <select class="form-select" id="edit_is_active" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div id="editDateError" class="alert alert-danger d-none" role="alert"></div>
                        <button type="submit" class="btn btn-red">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCurriculumModal" tabindex="-1" aria-labelledby="deleteCurriculumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCurriculumModalLabel">Delete Curriculum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this curriculum?
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
            var table = $('#curriculumsTable').DataTable();

            $('#addCurriculumForm').on('submit', function (e) {
                e.preventDefault();

                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());

                if (startDate >= endDate) {
                    $('#dateError').removeClass('d-none').text('Start date cannot be later than end date.');
                    return;
                } else {
                    $('#dateError').addClass('d-none').text('');
                }

                console.log('Submitting form...');

                $.ajax({
                    type: 'POST',
                    url: 'api/curriculum/add.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log('Raw response:', response);
                        try {
                            var result = JSON.parse(response);
                            console.log('Parsed response:', result);

                            if (result.status === 'success') {
                                $('#addCurriculumModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Curriculum added successfully!');
                                $('.modal-backdrop').remove();
                                // Clear the table
                                table.clear();

                                // Add the new data to the table
                                result.data.forEach(function (curriculum) {
                                    table.row.add([
                                        curriculum.name,
                                        curriculum.start_date,
                                        curriculum.end_date,
                                        curriculum.is_active == 1 ? 'Active' : 'Inactive',
                                        '<button class="btn btn-warning btn-sm edit-btn" data-id="' + curriculum.id + '" data-name="' + curriculum.name + '" data-start_date="' + curriculum.start_date + '" data-end_date="' + curriculum.end_date + '" data-is_active="' + curriculum.is_active + '">Edit</button> ' +
                                        '<button class="btn btn-danger btn-sm delete-btn" data-id="' + curriculum.id + '">Delete</button>'
                                    ]).draw();
                                });
                            } else {
                                $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Curriculum.');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Curriculum.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Curriculum.');
                    }
                });
            });

            // Edit curriculum
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var start_date = $(this).data('start_date');
                var end_date = $(this).data('end_date');
                var is_active = $(this).data('is_active');

                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_start_date').val(start_date);
                $('#edit_end_date').val(end_date);
                $('#edit_is_active').val(is_active);

                $('#editCurriculumModal').modal('show');
            });

            $('#editCurriculumForm').on('submit', function (e) {
                e.preventDefault();

                var startDate = new Date($('#edit_start_date').val());
                var endDate = new Date($('#edit_end_date').val());

                if (startDate >= endDate) {
                    $('#editDateError').removeClass('d-none').text('Start date cannot be later than end date.');
                    return;
                } else {
                    $('#editDateError').addClass('d-none').text('');
                }

                $.ajax({
                    type: 'POST',
                    url: 'api/curriculum/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log('Raw response:', response);
                        try {
                            var result = JSON.parse(response);
                            console.log('Parsed response:', result);

                            if (result.status === 'success') {
                                $('#editCurriculumModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Curriculum updated successfully!');

                                // Clear the table
                                table.clear();

                                // Add the new data to the table
                                result.data.forEach(function (curriculum) {
                                    table.row.add([
                                        curriculum.name,
                                        curriculum.start_date,
                                        curriculum.end_date,
                                        curriculum.is_active == 1 ? 'Active' : 'Inactive',
                                        '<button class="btn btn-warning btn-sm edit-btn" data-id="' + curriculum.id + '" data-name="' + curriculum.name + '" data-start_date="' + curriculum.start_date + '" data-end_date="' + curriculum.end_date + '" data-is_active="' + curriculum.is_active + '">Edit</button> ' +
                                        '<button class="btn btn-danger btn-sm delete-btn" data-id="' + curriculum.id + '">Delete</button>'
                                    ]).draw();
                                });
                            } else {
                                $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Curriculum.');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Curriculum.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Curriculum.');
                    }
                });
            });

            // Delete curriculum
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteCurriculumModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/curriculum/delete.php',
                    data: { id: id },
                    success: function (response) {
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteCurriculumModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Curriculum deleted successfully!');

                                // Clear the table
                                table.clear();

                                // Add the new data to the table
                                result.data.forEach(function (curriculum) {
                                    table.row.add([
                                        curriculum.name,
                                        curriculum.start_date,
                                        curriculum.end_date,
                                        curriculum.is_active == 1 ? 'Active' : 'Inactive',
                                        '<button class="btn btn-warning btn-sm edit-btn" data-id="' + curriculum.id + '" data-name="' + curriculum.name + '" data-start_date="' + curriculum.start_date + '" data-end_date="' + curriculum.end_date + '" data-is_active="' + curriculum.is_active + '">Edit</button> ' +
                                        '<button class="btn btn-danger btn-sm delete-btn" data-id="' + curriculum.id + '">Delete</button>'
                                    ]).draw();
                                });
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Curriculum.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Curriculum.');
                        $('#errorModal').modal('show');
                    }
                });

            });
        });


    </script>
</body>

</html>