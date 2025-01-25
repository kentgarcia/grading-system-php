# KMJS Grading System: A PHP-Based Student Management System

KMJS Grading System is a web-based application designed to manage students, courses, subjects, grades, and curriculums. It provides functionalities for adding, editing, and deleting records, as well as viewing logs of actions performed in the system.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [Contributing](#contributing)
- [License](#license)

## Features

- Manage students
- Manage courses
- Manage subjects
- Manage grades
- Manage curriculums
- View logs
- Responsive design

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/yourusername/kmjs-grading-system.git
   ```

2. Navigate to the project directory:

   ```sh
   cd kmjs-grading-system
   ```

3. Set up the database:

   - Create a MySQL database named `db_gradingsystem`.
   - Import the `db_gradingsystem.sql` file into your database.

   ```php
   <?php
   $host = 'localhost';
   $dbname = 'db_gradingsystem';
   $username = 'root';
   $password = '';

   $conn = new mysqli($host, $username, $password, $dbname);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

4. Start a local server (e.g., using XAMPP or WAMP) and place the project folder in the server's root directory.

5. Open your web browser and navigate to `http://localhost/kmjs-grading-system`.

## Usage

### Login

- Use the login form to enter your credentials and access the system.

### Dashboard

- View the total counts of students, subjects, courses, and curriculums.
- View logs of actions performed in the system.

### Manage Records

- Use the navigation menu to manage students, courses, subjects, grades, and curriculums.
- Add, edit, and delete records as needed.

## Folder Structure

```
.hintrc
api/
  courses/
    add.php
    delete.php
    edit.php
    get.php
  curriculum/
    add.php
    delete.php
    edit.php
  grades/
    add.php
    check_grade.php
    delete.php
    edit.php
    get.php
  logs/
    get_routines_and_triggers.php
    get.php
  students/
    add.php
    delete.php
    edit.php
  subjects/
  yearlevel/
assets/
  css/
  js/
    style.css
db.php
index.php
login.php
pages/
  courses.php
  curriculum.php
  dashboard.php
  grades.php
  students.php
  subject.php
  yearlevel.php
  sidebar.php
  tables.html
```

## Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
