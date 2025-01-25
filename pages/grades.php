<?php
include './db.php';

// Fetch students from the database
$studentsSql = "SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM Students";
$studentsResult = $conn->query($studentsSql);

// Fetch all results from the query
$students = [];
while ($row = $studentsResult->fetch_assoc()) {
    $students[] = $row;
}

// Fetch subjects from the database
$subjectsSql = "SELECT id, title FROM Subjects";
$subjectsResult = $conn->query($subjectsSql);

// Fetch all results from the query
$subjects = [];
while ($row = $subjectsResult->fetch_assoc()) {
    $subjects[] = $row;
}

// Fetch grades from the database
$gradesSql = "SELECT sg.id, s.first_name, s.last_name, sub.title AS subject_title, sg.grade
              FROM StudentGrades sg
              JOIN Students s ON sg.student_id = s.id
              JOIN Subjects sub ON sg.subject_id = sub.id";
$gradesResult = $conn->query($gradesSql);

// Fetch all results from the query
$grades = [];
while ($row = $gradesResult->fetch_assoc()) {
    $grades[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Grades Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Grades</h1>
            <p class="mb-4">This page shows the list of grades for each student.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Grades Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addGradeModal">Add
                                New
                                Grade</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="gradesTable">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <?php foreach ($grades as $grade): ?>
                                    <tr>
                                        <td><?= $grade['first_name'] . ' ' . $grade['last_name'] ?></td>
                                        <td><?= $grade['subject_title'] ?></td>
                                        <td><?= $grade['grade'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $grade['id'] ?>"
                                                data-student_id="<?= $grade['student_id'] ?>"
                                                data-subject_id="<?= $grade['subject_id'] ?>"
                                                data-grade="<?= $grade['grade'] ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?= $grade['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?> -->
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>

    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGradeModalLabel">Add New Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGradeForm">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-select" id="student_id" name="student_id" required>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subject_id" class="form-label">Subject</label>
                            <select class="form-select" id="subject_id" name="subject_id" required>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= $subject['id'] ?>"><?= $subject['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" step="0.01" class="form-control" id="grade" name="grade" required>
                        </div>
                        <!-- Alert for status -->
                        <div id="statusAddAlert" class="alert alert-danger d-none" role="alert"></div>
                        <button type="submit" class="btn btn-red">Add Grade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Grade Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGradeForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_student_id" class="form-label">Student</label>
                            <select class="form-select" id="edit_student_id" name="student_id" required>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_subject_id" class="form-label">Subject</label>
                            <select class="form-select" id="edit_subject_id" name="subject_id" required>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= $subject['id'] ?>"><?= $subject['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_grade" class="form-label">Grade</label>
                            <input type="number" step="0.01" class="form-control" id="edit_grade" name="grade" required>
                        </div>
                        <button type="submit" class="btn btn-red">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteCurriculumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCurriculumModalLabel">Delete Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this grade?
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
            var table = $('#gradesTable').DataTable();

            $('#addGradeForm').on('submit', function (e) {
                e.preventDefault();

                var studentId = $('#student_id').val();
                var subjectId = $('#subject_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'api/grades/check_grade.php',
                    contentType: 'application/json',
                    data: JSON.stringify({ studentId: studentId, subjectId: subjectId }),
                    success: function (response) {
                        console.log('Check Grade Response:', response); // Log the raw response

                        if (response.exists) {
                            $('#statusAddAlert').removeClass('d-none').addClass('alert-danger').text('Student already has a grade for this subject.');
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: 'api/grades/add.php',
                                data: $('#addGradeForm').serialize(),
                                success: function (response) {
                                    console.log('Add Grade Response:', response);

                                    if (response.status !== 'success') {
                                        $('#addGradeModal').modal('hide');
                                        $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Grade added successfully!');
                                        $('.modal-backdrop').remove();
                                        $('#statusAddAlert').addClass('d-none');
                                        fetchGrades();
                                    } else {
                                        $('#statusAddAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Grade.');
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.log('Add Grade Error:', status, error);
                                    $('#statusAddAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Grade.');
                                }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Check Grade Error:', status, error);
                        $('#statusAddAlert').removeClass('d-none').addClass('alert-danger').text('Failed to check grade.');
                    }
                });
            });

            function fetchGrades() {
                $.ajax({
                    type: 'GET',
                    url: 'api/grades/get.php',
                    success: function (response) {
                        console.log('Fetch Grades Response:', response);
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            // Clear the table
                            table.clear();

                            // Add the new data to the table
                            result.data.forEach(function (grade) {
                                table.row.add([
                                    grade.first_name + ' ' + grade.last_name,
                                    grade.subject_title,
                                    grade.grade,
                                    '<button class="btn btn-warning btn-sm edit-btn" data-id="' + grade.id + '" data-student_id="' + grade.student_id + '" data-subject_id="' + grade.subject_id + '" data-grade="' + grade.grade + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete-btn" data-id="' + grade.id + '">Delete</button>'
                                ]).draw();
                            });
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to fetch Grades.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Fetch Grades Error:', status, error);
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to fetch Grades.');
                    }
                });
            }

            // Fetch grades on page load
            fetchGrades();

            // Edit grade
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var student_id = $(this).data('student_id');
                var subject_id = $(this).data('subject_id');
                var grade = $(this).data('grade');

                console.log('Edit Grade Data:', { id, student_id, subject_id, grade });

                $('#edit_id').val(id);
                $('#edit_student_id').val(student_id);
                $('#edit_subject_id').val(subject_id);
                $('#edit_grade').val(grade);

                $('#edit_student_id option').each(function () {
                    if ($(this).val() == student_id) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('#edit_subject_id option').each(function () {
                    if ($(this).val() == subject_id) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('#editGradeModal').modal('show');
            });

            $('#editGradeForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/grades/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log('Edit Grade Response:', response);
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#editGradeModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Grade updated successfully!');

                            // Optionally, fetch and update the table with the updated grade
                            fetchGrades();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Grade.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Edit Grade Error:', status, error);
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Grade.');
                    }
                });
            });

            // Delete grade
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/grades/delete.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Grade deleted successfully!');
                                fetchGrades();
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Grade.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Grade.');
                        $('#errorModal').modal('show');
                    }
                });

            });

        });
    </script>
</body>

</html>