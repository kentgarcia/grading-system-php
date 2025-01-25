-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 02:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gradingsystem`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddCourse` (IN `title` VARCHAR(100), IN `year_level_id` INT)   BEGIN
    INSERT INTO Courses (title, year_level_id) VALUES (title, year_level_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddCurriculum` (IN `name` VARCHAR(100), IN `start_date` DATE, IN `end_date` DATE, IN `is_active` TINYINT)   BEGIN
    UPDATE Curriculums SET is_active = 0 WHERE is_active = 1;
    INSERT INTO Curriculums (name, start_date, end_date, is_active) VALUES (name, start_date, end_date, is_active);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddStudent` (IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50), IN `age` INT, IN `course_id` INT)   BEGIN
    INSERT INTO Students (first_name, last_name, age, course_id) VALUES (first_name, last_name, age, course_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddStudentGrade` (IN `student_id` INT, IN `subject_id` INT, IN `grade` DECIMAL(5,2))   BEGIN
    INSERT INTO StudentGrades (student_id, subject_id, grade) VALUES (student_id, subject_id, grade);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddSubject` (IN `title` VARCHAR(100), IN `code` VARCHAR(50), IN `course_id` INT)   BEGIN
    INSERT INTO Subjects (title, code, course_id) VALUES (title, code, course_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddYearLevel` (IN `level_name` VARCHAR(50), IN `curriculum_id` INT)   BEGIN
    INSERT INTO YearLevels (level_name, curriculum_id) VALUES (level_name, curriculum_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddYearLevels` (IN `curriculum_id` INT)   BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 4 DO
        INSERT INTO YearLevels (level_name, curriculum_id) VALUES (CONCAT('Year ', i), curriculum_id);
        SET i = i + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteCourse` (IN `id` INT)   BEGIN
    DELETE FROM Courses WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteCurriculum` (IN `curriculum_id` INT)   BEGIN
    DELETE FROM Curriculums WHERE id = curriculum_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteStudent` (IN `id` INT)   BEGIN
    DELETE FROM StudentGrades WHERE student_id = id;
    DELETE FROM Students WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteStudentGrade` (IN `id` INT)   BEGIN
    DELETE FROM StudentGrades WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteSubject` (IN `id` INT)   BEGIN
    DELETE FROM StudentGrades WHERE subject_id = id;
    DELETE FROM Subjects WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteYearLevel` (IN `id` INT)   BEGIN
    DELETE FROM YearLevels WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditCourse` (IN `id` INT, IN `title` VARCHAR(100), IN `year_level_id` INT)   BEGIN
    UPDATE Courses SET title = title, year_level_id = year_level_id WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditCurriculum` (IN `p_id` INT, IN `name` VARCHAR(100), IN `start_date` DATE, IN `end_date` DATE, IN `is_active` TINYINT)   BEGIN
    UPDATE Curriculums SET name = name, start_date = start_date, end_date = end_date, is_active = is_active WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditStudent` (IN `id` INT, IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50), IN `age` INT, IN `course_id` INT)   BEGIN
    UPDATE Students SET first_name = first_name, last_name = last_name, age = age, course_id = course_id WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditStudentGrade` (IN `id` INT, IN `student_id` INT, IN `subject_id` INT, IN `grade` DECIMAL(5,2))   BEGIN
    UPDATE StudentGrades SET student_id = student_id, subject_id = subject_id, grade = grade WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditSubject` (IN `id` INT, IN `title` VARCHAR(100), IN `code` VARCHAR(50), IN `course_id` INT)   BEGIN
    UPDATE Subjects SET title = title, code = code, course_id = course_id WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditYearLevel` (IN `id` INT, IN `level_name` VARCHAR(50), IN `curriculum_id` INT)   BEGIN
    UPDATE YearLevels SET level_name = level_name, curriculum_id = curriculum_id WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCourses` ()   BEGIN
    SELECT c.id, c.title, 
           CASE 
               WHEN yl.id IS NULL THEN 'DELETED YEAR LEVEL' 
               ELSE yl.level_name 
           END AS level_name
    FROM Courses c
    LEFT JOIN YearLevels yl ON c.year_level_id = yl.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCurriculums` ()   BEGIN
    SELECT * FROM Curriculums;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStudentGrades` ()   BEGIN
    SELECT sg.id, s.first_name, s.last_name, sub.title AS subject_title, sg.grade
    FROM StudentGrades sg
    JOIN Students s ON sg.student_id = s.id
    JOIN Subjects sub ON sg.subject_id = sub.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStudents` ()   BEGIN
    SELECT s.id, s.first_name, s.last_name, s.age, s.avg_grade, c.title AS course_title, s.course_id
    FROM Students s
    JOIN Courses c ON s.course_id = c.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetSubjects` ()   BEGIN
    SELECT s.id, s.title, s.code, c.title AS course_title, s.course_id
    FROM Subjects s
    JOIN Courses c ON s.course_id = c.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetYearLevels` ()   BEGIN
    SELECT yl.id, yl.level_name, c.name AS curriculum_name, yl.curriculum_id
    FROM YearLevels yl
    JOIN Curriculums c ON yl.curriculum_id = c.id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GetCourseTitle` (`course_id` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE course_title VARCHAR(100);

    SELECT title INTO course_title
    FROM Courses
    WHERE id = course_id;

    RETURN course_title;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetCurriculumName` (`curriculum_id` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE curriculum_name VARCHAR(100);

    SELECT name INTO curriculum_name
    FROM Curriculums
    WHERE id = curriculum_id;

    RETURN curriculum_name;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetStudentAvgGrade` (`student_id` INT) RETURNS DECIMAL(5,2)  BEGIN
    DECLARE avg_grade DECIMAL(5,2);

    SELECT AVG(grade) INTO avg_grade
    FROM StudentGrades
    WHERE student_id = student_id;

    RETURN avg_grade;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetSubjectTitle` (`subject_id` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE subject_title VARCHAR(100);

    SELECT title INTO subject_title
    FROM Subjects
    WHERE id = subject_id;

    RETURN subject_title;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetYearLevelName` (`year_level_id` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE year_level_name VARCHAR(50);

    SELECT level_name INTO year_level_name
    FROM YearLevels
    WHERE id = year_level_id;

    RETURN year_level_name;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `year_level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `year_level_id`) VALUES
(48, 'Bachelor of Science in Information Technology', 55),
(49, 'Bachelor of Science in Business Administration', 55),
(50, 'Bachelor of Science in Accounting', 55),
(51, 'Bachelor of Science in Information Technology', 56),
(52, 'Bachelor of Science in Business Administration', 56),
(53, 'Bachelor of Science in Accounting', 56),
(54, 'Bachelor of Science in Information Technology', 57),
(55, 'Bachelor of Science in Business Administration', 57),
(56, 'Bachelor of Science in Accounting', 57),
(57, 'Bachelor of Science in Information Technology', 58),
(58, 'Bachelor of Science in Business Administration', 58),
(59, 'Bachelor of Science in Accounting', 58);

--
-- Triggers `courses`
--
DELIMITER $$
CREATE TRIGGER `after_course_delete` AFTER DELETE ON `courses` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Deleted course with ID: ', OLD.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_course_insert` AFTER INSERT ON `courses` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Inserted course with ID: ', NEW.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_course_update` AFTER UPDATE ON `courses` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Updated course with ID: ', NEW.id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `curriculums`
--

CREATE TABLE `curriculums` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculums`
--

INSERT INTO `curriculums` (`id`, `name`, `start_date`, `end_date`, `is_active`) VALUES
(48, 'BSIT 2025 CURRRICULUM', '2024-01-03', '2025-02-04', 1);

--
-- Triggers `curriculums`
--
DELIMITER $$
CREATE TRIGGER `after_curriculum_insert` AFTER INSERT ON `curriculums` FOR EACH ROW BEGIN
    CALL AddYearLevels(NEW.id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `action`, `timestamp`) VALUES
(101, 'Inserted course with ID: 48', '2025-01-25 15:52:12'),
(102, 'Inserted course with ID: 49', '2025-01-25 15:52:12'),
(103, 'Inserted course with ID: 50', '2025-01-25 15:52:12'),
(104, 'Inserted course with ID: 51', '2025-01-25 15:52:12'),
(105, 'Inserted course with ID: 52', '2025-01-25 15:52:12'),
(106, 'Inserted course with ID: 53', '2025-01-25 15:52:12'),
(107, 'Inserted course with ID: 54', '2025-01-25 15:52:12'),
(108, 'Inserted course with ID: 55', '2025-01-25 15:52:12'),
(109, 'Inserted course with ID: 56', '2025-01-25 15:52:12'),
(110, 'Inserted course with ID: 57', '2025-01-25 15:52:12'),
(111, 'Inserted course with ID: 58', '2025-01-25 15:52:12'),
(112, 'Inserted course with ID: 59', '2025-01-25 15:52:12'),
(113, 'Inserted subject with ID: 17', '2025-01-25 15:52:43'),
(114, 'Inserted subject with ID: 18', '2025-01-25 15:52:52'),
(115, 'Updated subject with ID: 18', '2025-01-25 15:53:13'),
(116, 'Inserted student with ID: 9', '2025-01-25 15:53:31'),
(117, 'Updated student with ID: 9', '2025-01-25 15:53:45'),
(118, 'Updated student with ID: 9', '2025-01-25 15:53:53'),
(119, 'Updated student with ID: 9', '2025-01-25 15:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `studentgrades`
--

CREATE TABLE `studentgrades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentgrades`
--

INSERT INTO `studentgrades` (`id`, `student_id`, `subject_id`, `grade`) VALUES
(22, 9, 17, 98.00),
(23, 9, 18, 90.00);

--
-- Triggers `studentgrades`
--
DELIMITER $$
CREATE TRIGGER `after_grade_delete` AFTER DELETE ON `studentgrades` FOR EACH ROW BEGIN
    DECLARE avg_grade DECIMAL(5,2);

    -- Calculate the new average grade for the student
    SELECT AVG(grade) INTO avg_grade
    FROM StudentGrades
    WHERE student_id = OLD.student_id;

    -- Update the student's average grade
    UPDATE Students
    SET avg_grade = avg_grade
    WHERE id = OLD.student_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_grade_insert` AFTER INSERT ON `studentgrades` FOR EACH ROW BEGIN
    DECLARE avg_grade DECIMAL(5,2);

    -- Calculate the new average grade for the student
    SELECT AVG(grade) INTO avg_grade
    FROM StudentGrades
    WHERE student_id = NEW.student_id;

    -- Update the student's average grade
    UPDATE Students
    SET avg_grade = avg_grade
    WHERE id = NEW.student_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_grade_update` AFTER UPDATE ON `studentgrades` FOR EACH ROW BEGIN
    DECLARE avg_grade DECIMAL(5,2);

    -- Calculate the new average grade for the student
    SELECT AVG(grade) INTO avg_grade
    FROM StudentGrades
    WHERE student_id = NEW.student_id;

    -- Update the student's average grade
    UPDATE Students
    SET avg_grade = avg_grade
    WHERE id = NEW.student_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `avg_grade` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `age`, `course_id`, `avg_grade`) VALUES
(9, 'JASPER', 'PRIAS', 21, 48, 94.00);

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `after_student_delete` AFTER DELETE ON `students` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Deleted student with ID: ', OLD.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `students` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Inserted student with ID: ', NEW.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_student_update` AFTER UPDATE ON `students` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Updated student with ID: ', NEW.id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `title`, `code`, `course_id`) VALUES
(17, 'DBA', 'COMP018', 48),
(18, 'PROGGRAMMING', 'PROG002', 48);

--
-- Triggers `subjects`
--
DELIMITER $$
CREATE TRIGGER `after_subject_delete` AFTER DELETE ON `subjects` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Deleted subject with ID: ', OLD.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_subject_insert` AFTER INSERT ON `subjects` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Inserted subject with ID: ', NEW.id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_subject_update` AFTER UPDATE ON `subjects` FOR EACH ROW BEGIN
    INSERT INTO Logs (action) VALUES (CONCAT('Updated subject with ID: ', NEW.id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `yearlevels`
--

CREATE TABLE `yearlevels` (
  `id` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yearlevels`
--

INSERT INTO `yearlevels` (`id`, `curriculum_id`, `level_name`) VALUES
(55, 48, 'Year 1'),
(56, 48, 'Year 2'),
(57, 48, 'Year 3'),
(58, 48, 'Year 4');

--
-- Triggers `yearlevels`
--
DELIMITER $$
CREATE TRIGGER `after_yearlevel_insert` AFTER INSERT ON `yearlevels` FOR EACH ROW BEGIN
    -- Insert new courses with the new year level
    INSERT INTO Courses (title, year_level_id) VALUES 
    ('Bachelor of Science in Information Technology', NEW.id),
    ('Bachelor of Science in Business Administration', NEW.id),
    ('Bachelor of Science in Accounting', NEW.id);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year_level_id` (`year_level_id`);

--
-- Indexes for table `curriculums`
--
ALTER TABLE `curriculums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentgrades`
--
ALTER TABLE `studentgrades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `yearlevels`
--
ALTER TABLE `yearlevels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_id` (`curriculum_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `curriculums`
--
ALTER TABLE `curriculums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `studentgrades`
--
ALTER TABLE `studentgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `yearlevels`
--
ALTER TABLE `yearlevels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`year_level_id`) REFERENCES `yearlevels` (`id`);

--
-- Constraints for table `studentgrades`
--
ALTER TABLE `studentgrades`
  ADD CONSTRAINT `studentgrades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `studentgrades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `yearlevels`
--
ALTER TABLE `yearlevels`
  ADD CONSTRAINT `yearlevels_ibfk_1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculums` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
