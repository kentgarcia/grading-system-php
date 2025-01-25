<?php
include './db.php';

// Fetch year levels from the database
$sql = "SELECT yl.id, yl.level_name, 
               CASE 
                   WHEN c.id IS NULL THEN 'DELETED CURRICULUM' 
                   ELSE c.name 
               END AS curriculum_name
        FROM YearLevels yl
        LEFT JOIN Curriculums c ON yl.curriculum_id = c.id";
$result = $conn->query($sql);

$yearlevels = [];
while ($row = $result->fetch_assoc()) {
    $yearlevels[] = $row;
}

// Fetch courses from the database
$coursesSql = "SELECT c.id, c.title, yl.level_name, c.year_level_id
               FROM Courses c
               JOIN YearLevels yl ON c.year_level_id = yl.id";
$coursesResult = $conn->query($coursesSql);

// Fetch all results from the query
$courses = [];
while ($row = $coursesResult->fetch_assoc()) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Courses Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <main>
        <div class="container-fluid px-4">
            <h1 class="h3 mb-2 text-gray-800">Courses</h1>
            <p class="mb-4">This is the courses management page. You can add, edit, and delete courses here.
            </p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-red">Curriculum Table</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add
                                New
                                Course</button>
                        </div>
                    </div>

                    <!-- Alert for status -->
                    <div id="statusAlert" class="alert alert-success d-none" role="alert"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="coursesTable">
                            <thead>
                                <tr>
                                    <th>Course Title</th>
                                    <th>Year Level</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= $course['title'] ?></td>
                                        <td><?= $course['level_name'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $course['id'] ?>"
                                                data-title="<?= $course['title'] ?>"
                                                data-year_level_id="<?= $course['year_level_id'] ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?= $course['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?> -->
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>

    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCourseForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="year_level_id" class="form-label">Year Level</label>
                            <select id="year_level_id" name="year_level_id" class="form-select" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-red">Add Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCourseForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_year_level_id" class="form-label">Year Level</label>
                            <select id="edit_year_level_id" name="year_level_id" class="form-select" required>
                                <!-- Options will be populated by JavaScript -->
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
                    <h5 class="modal-title" id="deleteModalLabel">Delete Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this course?
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
            var table = $('#coursesTable').DataTable();

            $('#addCourseForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/courses/add.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#addCourseModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Course added successfully!');
                            $('.modal-backdrop').remove();
                            // Optionally, fetch and update the table with the new course
                            fetchCourses();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Course.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to add Course.');
                    }
                });
            });

            function fetchCourses() {
                $.ajax({
                    type: 'GET',
                    url: 'api/courses/get.php',
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        if (response.status === 'success') {
                            // Clear the table
                            table.clear();

                            // Add the new data to the table
                            response.data.forEach(function (course) {
                                table.row.add([
                                    course.title,
                                    course.level_name,
                                    '<button class="btn btn-warning btn-sm edit-btn" data-id="' + course.id + '" data-title="' + course.title + '" data-year_level_id="' + course.year_level_id + '">Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm delete-btn" data-id="' + course.id + '">Delete</button>'
                                ]).draw();
                            });
                        } else {
                            $('#errorModalBody').text(response.message);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to retrieve courses.');
                        $('#errorModal').modal('show');
                    }
                });
            }
            // Fetch courses on page load
            fetchCourses();

            function fetchYearLevels() {
                $.ajax({
                    type: 'GET',
                    url: 'api/yearlevel/get.php',
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                var yearLevelDropdown = $('#year_level_id');
                                yearLevelDropdown.empty();
                                result.data.forEach(function (yearlevel) {
                                    var optionText = yearlevel.level_name + ' - ' + yearlevel.curriculum_name;
                                    yearLevelDropdown.append(new Option(optionText, yearlevel.id));
                                });

                                var yearLevelDropdown = $('#edit_year_level_id');
                                yearLevelDropdown.empty();
                                result.data.forEach(function (yearlevel) {
                                    var optionText = yearlevel.level_name + ' - ' + yearlevel.curriculum_name;
                                    yearLevelDropdown.append(new Option(optionText, yearlevel.id));
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
            fetchYearLevels();

            // Edit course
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var year_level_id = $(this).data('year_level_id');

                $('#edit_id').val(id);
                $('#edit_title').val(title);
                $('#edit_year_level_id').val(year_level_id);

                $('#editCourseModal').modal('show');
            });

            $('#editCourseForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'api/courses/edit.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var result = JSON.parse(response);

                        if (result.status === 'success') {
                            $('#editCourseModal').modal('hide');
                            $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Course updated successfully!');
                            fetchCourses();
                        } else {
                            $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Course.');
                        }
                    },
                    error: function () {
                        $('#statusAlert').removeClass('d-none').addClass('alert-danger').text('Failed to update Course.');
                    }
                });
            });

            // Delete course

            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#confirmDeleteBtn').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'api/courses/delete.php',
                    data: { id: id },
                    success: function (response) {
                        console.log('Raw response:', response); // Log the raw response
                        try {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                $('#deleteModal').modal('hide');
                                $('#statusAlert').removeClass('d-none').addClass('alert-success').text('Course deleted successfully!');
                                fetchCourses();
                            } else {
                                $('#errorModalBody').text(result.message);
                                $('#errorModal').modal('show');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#errorModalBody').text('Failed to delete Course.');
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', status, error);
                        $('#errorModalBody').text('Failed to delete Course.');
                        $('#errorModal').modal('show');
                    }
                });

            });
        });
    </script>

    <!-- Page level plugins -->
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/datatables.js"></script>
</body>

</html>