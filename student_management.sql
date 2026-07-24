-- ==========================================
-- Student Management System Database
-- ==========================================

CREATE DATABASE IF NOT EXISTS student_management;
USE student_management;

-- ==========================================
-- Students Table
-- ==========================================

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_no VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    semester VARCHAR(20),
    email VARCHAR(100),
    mobile VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- Attendance Table
-- ==========================================

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    status ENUM('Present','Absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE
);

-- ==========================================
-- Subjects Table
-- ==========================================

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20),
    subject_name VARCHAR(100),
    department VARCHAR(100),
    semester VARCHAR(20)
);

-- ==========================================
-- Marks Table
-- ==========================================

CREATE TABLE marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    total_marks INT NOT NULL,
    obtained_marks INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
        ON DELETE CASCADE
);

-- ==========================================
-- Results Table
-- ==========================================

CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    total_marks INT,
    obtained_marks INT,
    percentage DECIMAL(5,2),
    grade VARCHAR(5),
    status VARCHAR(20),
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE
);

-- ==========================================
-- Users Table
-- ==========================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    full_name VARCHAR(100),
    role ENUM('Admin','Faculty','Student')
);

-- ==========================================
-- Sample Users
-- ==========================================

INSERT INTO users(username,password,full_name,role)
VALUES
('admin','admin123','System Administrator','Admin'),
('faculty','faculty123','Faculty Member','Faculty'),
('student','student123','Student User','Student');

-- ==========================================
-- Sample Students
-- ==========================================

INSERT INTO students
(roll_no,name,department,semester,email,mobile)
VALUES
('CS001','Rahul Sharma','Computer','5','rahul@gmail.com','9876543210'),
('CS002','Priya Patil','Computer','5','priya@gmail.com','9876543211'),
('IT001','Rohan Patil','IT','5','rohan@gmail.com','9876543212'),
('AI001','Sneha Joshi','AIML','5','sneha@gmail.com','9876543213');

-- ==========================================
-- Sample Subjects
-- ==========================================

INSERT INTO subjects
(subject_code,subject_name,department,semester)
VALUES
('PHP101','PHP Programming','Computer','5'),
('JAVA101','Java Programming','Computer','5'),
('DBMS101','Database Management','Computer','5'),
('WT101','Web Technology','Computer','5');

-- ==========================================
-- Sample Marks
-- ==========================================

INSERT INTO marks
(student_id,subject_id,total_marks,obtained_marks)
VALUES
(1,1,100,90),
(1,2,100,85),
(1,3,100,88),
(1,4,100,82),

(2,1,100,78),
(2,2,100,80),
(2,3,100,76),
(2,4,100,84);

-- ==========================================
-- Sample Results
-- ==========================================

INSERT INTO results
(student_id,total_marks,obtained_marks,percentage,grade,status)
VALUES
(1,400,345,86.25,'A','PASS'),
(2,400,318,79.50,'B+','PASS');

-- ==========================================
-- Sample Attendance
-- ==========================================

INSERT INTO attendance
(student_id,attendance_date,status)
VALUES
(1,'2026-07-20','Present'),
(2,'2026-07-20','Absent'),
(3,'2026-07-20','Present'),
(4,'2026-07-20','Present');