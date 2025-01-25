<?php
include './db.php';

$sql = "SELECT c.id, c.title AS title, yl.level_name
        FROM Courses c
        JOIN YearLevels yl ON c.year_level_id = yl.id";
$result = $conn->query($sql);

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
// Fetch subjects from the database
$subjectsSql = "SELECT s.id, s.title, s.code, c.title AS course_title, yl.level_name, s.course_id
                FROM Subjects s
                JOIN Courses c ON s.course_id = c.id
                JOIN YearLevels yl ON c.year_level_id = yl.id";
$subjectsResult = $conn->query($subjectsSql);

// Fetch all results from the query
$subjects = [];
while ($row = $subjectsResult->fetch_assoc()) {
    $subjects[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Subjects Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>

    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Subjects</h1>
            <p class="mb-4">This is the subjects management page. You can add, edit, and delete subjects here.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Subjects Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addSubjectModal">Add
                                New
                                Subject</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="subjectsTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subjects as $subject): ?>
                                    <tr>
                                        <td><?= $subject['title'] ?></td>
                                        <td><?= $subject['code'] ?></td>
                                        <td><?= $subject['course_title'] ?></td>
                                        <td><?= $subject['level_name'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $subject['id'] ?>"
                                                data-title="<?= $subject['title'] ?>" data-code="<?= $subject['code'] ?>"
                                                data-course_id="<?= $subject['course_id'] ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?= $subject['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSubjectForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?> -
                                        <?= $course['level_name'] ?>
                                    </option> <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Add Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubjectForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="edit_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_course_id" class="form-label">Course</label>
                            <select class="form-select" id="edit_course_id" name="course_id" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?> -
                                        <?= $course['level_name'] ?>
                                    </option>
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
                    <h5 class="modal-title" id="deleteModalLabel">Delete Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this subject?
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
            var table = $('#subjectsTable').DataTable();

            $('#addSubjectForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/subjects/add.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#addSubjectModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Subject added successfully!');
                            $('.modal-backdrop').remove();
                            // Optionally, fetch and update the table with the new subject
                            fetchSubjects();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Subject.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Subject.');
                    }
                });
            });

            function fetchSubjects() {
                $.ajax({
                    type: 'GET',
                    url: 'api/subjects/get.php',
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        if (response.status === 'success') {
                            // Clear the table
                            table.clear();

                            // Add the new data to the table
                            response.data.forEach(function (subject) {
                                table.row.add([
                                    subject.title,
                                    subject.code,
                                    subject.course_title,
                                    subject.level_name,
                                    '<button class="btn btn-warning btn-sm edit-btn" data-id="' + subject.id + '" data-title="' + subject.title + '" data-code="' + subject.code + '" data-course_id="' + subject.course_id + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete-btn" data-id="' + subject.id + '">Delete</button>'
                                ]).draw();
                            });
                        } else {
                            $('#errorModalBody').text(response.message);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to retrieve subjects.');
                        $('#errorModal').modal('show');
                    }
                });
            }

            // Fetch subjects on page load
            fetchSubjects();

            // Edit subject
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var code = $(this).data('code');
                var course_id = $(this).data('course_id');

                $('#edit_id').val(id);
                $('#edit_title').val(title);
                $('#edit_code').val(code);
                $('#edit_course_id').val(course_id);

                $('#editSubjectModal').modal('show');
            });

            $('#editSubjectForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/subjects/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#editSubjectModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Subject updated successfully!');

                            // Optionally, fetch and update the table with the updated subject
                            fetchSubjects();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Subject.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Subject.');
                    }
                });
            });

            // Delete subject
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/subjects/delete.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Subject deleted successfully!');
                                fetchSubjects();
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Subject.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Subject.');
                        $('#errorModal').modal('show');
                    }
                });

            });
        });
    </script>
</body>

</html>