-- backend/sql/database.sql
-- ExamShield LPS Schema (Updated with Users and Results)

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin', 'Teacher', 'Student') NOT NULL DEFAULT 'Student',
  `name` varchar(100) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `question_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `type` enum('MCQ', 'Descriptive', 'True/False') NOT NULL,
  `difficulty` enum('Easy', 'Medium', 'Hard') NOT NULL,
  `marks` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `exam_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `exam_type` varchar(50) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `passing_marks` int(11) NOT NULL,
  `instructions` text,
  `status` enum('Draft', 'Scheduled', 'Published') DEFAULT 'Draft',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `exam_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`exam_id`) REFERENCES `exam_master`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`question_id`) REFERENCES `question_bank`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `exam_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in minutes',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`exam_id`) REFERENCES `exam_master`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `status` enum('Pass', 'Fail') NOT NULL,
  `submitted_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`exam_id`) REFERENCES `exam_master`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `users` (`username`, `password`, `role`, `name`) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'System Administrator'); -- Password is 'password'

INSERT INTO `departments` (`name`) VALUES ('Computer Science'), ('Information Technology');

INSERT INTO `subjects` (`department_id`, `name`, `code`) VALUES 
(1, 'Database Management Systems', 'CS301'),
(1, 'Data Structures', 'CS201'),
(2, 'Web Technology', 'IT401');

INSERT INTO `question_bank` (`subject_id`, `unit`, `question_text`, `type`, `difficulty`, `marks`) VALUES
(1, 1, 'What is normalization?', 'Descriptive', 'Medium', 5),
(1, 2, 'Which of the following is not a NoSQL database?', 'MCQ', 'Easy', 1),
(1, 3, 'Explain ACID properties in DBMS.', 'Descriptive', 'Hard', 10),
(2, 1, 'What is a binary tree?', 'Descriptive', 'Medium', 5),
(2, 2, 'Array elements are stored in contiguous memory locations. (True/False)', 'True/False', 'Easy', 1),
(3, 1, 'What does HTML stand for?', 'MCQ', 'Easy', 1);
