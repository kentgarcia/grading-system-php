<?php
include './db.php';

// Fetch courses from the database
$coursesSql = "SELECT id, title FROM Courses";
$coursesResult = $conn->query($coursesSql);

// Fetch all results from the query
$courses = [];
while ($row = $coursesResult->fetch_assoc()) {
    $courses[] = $row;
}

// Fetch students from the database
$studentsSql = "SELECT s.id, s.first_name, s.last_name, s.age, s.avg_grade, 
                       CASE 
                           WHEN c.id IS NULL THEN 'N/A' 
                           ELSE c.title 
                       END AS course_title, 
                       s.course_id
                FROM Students s
                LEFT JOIN Courses c ON s.course_id = c.id";
$studentsResult = $conn->query($studentsSql);


// Fetch all results from the query
$students = [];
while ($row = $studentsResult->fetch_assoc()) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Students Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Students</h1>
            <p class="mb-4">This page shows the list of students. You can add, edit, and delete students from this page.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Students Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add
                                New
                                Student</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="studentsTable">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>Course</th>
                                    <th>Average Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?= $student['first_name'] ?></td>
                                        <td><?= $student['last_name'] ?></td>
                                        <td><?= $student['age'] ?></td>
                                        <td><?= $student['course_title'] ?></td>
                                        <td><?= $student['avg_grade'] ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-btn"
                                                data-id="<?= $student['id'] ?>">View</button>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $student['id'] ?>"
                                                data-first_name="<?= $student['first_name'] ?>"
                                                data-last_name="<?= $student['last_name'] ?>"
                                                data-age="<?= $student['age'] ?>"
                                                data-course_id="<?= $student['course_id'] ?>">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?= $student['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="edit_age" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_course_id" class="form-label">Course</label>
                            <select class="form-select" id="edit_course_id" name="course_id" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Student Modal -->
    <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewStudentModalLabel">View Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Student Details</h5>
                    <p id="studentDetails"></p>
                    <h5>Grades</h5>
                    <table class="table table-bordered" id="gradesTable">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Grades will be dynamically populated here -->
                        </tbody>
                    </table>
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
            var table = $('#studentsTable').DataTable();

            $('#addStudentForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/students/add.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#addStudentModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Student added successfully!');
                            $('.modal-backdrop').remove();
                            // Optionally, fetch and update the table with the new student
                            fetchStudents();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Student.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Student.');
                    }
                });
            });

            function fetchStudents() {
                $.ajax({
                    type: 'GET',
                    url: 'api/students/get.php',
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            // Clear the table
                            table.clear();

                            // Add the new data to the table
                            result.data.forEach(function (student) {
                                table.row.add([
                                    student.first_name,
                                    student.last_name,
                                    student.age,
                                    student.course_title,
                                    student.avg_grade,
                                    '<button class="btn btn-info btn-sm view-btn" data-id="' + student.id + '">View</button> ' +
                                    '<button class="btn btn-warning btn-sm edit-btn" data-id="' + student.id + '" data-first_name="' + student.first_name + '" data-last_name="' + student.last_name + '" data-age="' + student.age + '" data-course_id="' + student.course_id + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete-btn" data-id="' + student.id + '">Delete</button>'
                                ]).draw();
                            });
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to fetch Students.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to fetch Students.');
                    }
                });
            }

            // Fetch students on page load
            fetchStudents();

            // Edit student
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var first_name = $(this).data('first_name');
                var last_name = $(this).data('last_name');
                var age = $(this).data('age');
                var course_id = $(this).data('course_id');

                $('#edit_id').val(id);
                $('#edit_first_name').val(first_name);
                $('#edit_last_name').val(last_name);
                $('#edit_age').val(age);
                $('#edit_course_id').val(course_id);

                $('#editStudentModal').modal('show');
            });

            $('#editStudentForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/students/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#editStudentModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Student updated successfully!');

                            // Optionally, fetch and update the table with the updated student
                            fetchStudents();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Student.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Student.');
                    }
                });
            });

            // Delete student
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/students/delete.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Student deleted successfully!');
                                fetchStudents();
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Student.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Student.');
                        $('#errorModal').modal('show');
                    }
                });

            });

            // View student
            $(document).on('click', '.view-btn', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: 'api/students/view.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                var student = result.data.student;
                                var grades = result.data.grades;

                                $('#studentDetails').html(`
                                    <p><strong>First Name:</strong> ${student.first_name}</p>
                                    <p><strong>Last Name:</strong> ${student.last_name}</p>
                                    <p><strong>Age:</strong> ${student.age}</p>
                                    <p><strong>Course:</strong> ${student.course_title}</p>
                                    <p><strong>Average Grade:</strong> ${student.avg_grade}</p>
                                `);

                                var gradesTable = $('#gradesTable tbody');
                                gradesTable.empty();
                                grades.forEach(function (grade) {
                                    gradesTable.append(`
                                        <tr>
                                            <td>${grade.subject_title}</td>
                                            <td>${grade.grade}</td>
                                        </tr>
                                    `);
                                });

                                $('#viewStudentModal').modal('show');
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to retrieve student details.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to retrieve student details.');
                        $('#errorModal').modal('show');
                    }
                });
            });
        });
    </script>
</body>

</html>