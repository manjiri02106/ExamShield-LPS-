-- ==========================================
-- Student Result Management & Reports Database
-- ==========================================

CREATE DATABASE IF NOT EXISTS examshield_lps;
USE examshield_lps;

-- ------------------------------------------
-- Table: departments
-- ------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL,
    department_code VARCHAR(20) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------
-- Table: students
-- ------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_no VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------
-- Table: exams
-- ------------------------------------------
CREATE TABLE IF NOT EXISTS exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_name VARCHAR(100) NOT NULL,
    exam_code VARCHAR(20) NOT NULL UNIQUE,
    total_marks INT NOT NULL DEFAULT 100,
    exam_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------
-- Table: results
-- ------------------------------------------
CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    marks DECIMAL(6,2) NOT NULL,
    total_marks DECIMAL(6,2) NOT NULL DEFAULT 100.00,
    percentage DECIMAL(5,2) NOT NULL,
    status ENUM('Pass', 'Fail') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    UNIQUE KEY uq_student_exam (student_id, exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- SAMPLE DATA INSERTS
-- ==========================================

-- Insert Departments
INSERT INTO departments (id, department_name, department_code) VALUES
(1, 'Computer Engineering', 'CS'),
(2, 'Information Technology', 'IT'),
(3, 'Artificial Intelligence & DS', 'AIDS'),
(4, 'Electronics & Telecom', 'EXTC'),
(5, 'Mechanical Engineering', 'MECH')
ON DUPLICATE KEY UPDATE department_name=VALUES(department_name);

-- Insert Exams
INSERT INTO exams (id, exam_name, exam_code, total_marks, exam_date) VALUES
(1, 'Mid-Term Examination 2026', 'EX-MID-2026', 100, '2026-02-15'),
(2, 'Final Semester Exam 2026', 'EX-FIN-2026', 100, '2026-05-20'),
(3, 'Practical & Oral Assessment', 'EX-PRA-2026', 50, '2026-07-10'),
(4, 'Unit Test 1 - 2026', 'EX-UT1-2026', 50, '2026-01-10'),
(5, 'Unit Test 2 - 2026', 'EX-UT2-2026', 50, '2026-03-12'),
(6, 'Autumn Assessment 2026', 'EX-AUT-2026', 100, '2026-09-18'),
(7, 'Winter Special Exam 2026', 'EX-WIN-2026', 100, '2026-11-25')
ON DUPLICATE KEY UPDATE exam_name=VALUES(exam_name);

-- Insert Students
INSERT INTO students (id, enrollment_no, name, email, department_id) VALUES
(1, 'EN2026001', 'Aarav Sharma', 'aarav.sharma@example.com', 1),
(2, 'EN2026002', 'Ananya Verma', 'ananya.verma@example.com', 1),
(3, 'EN2026003', 'Rohan Kulkarni', 'rohan.kulkarni@example.com', 2),
(4, 'EN2026004', 'Priya Patel', 'priya.patel@example.com', 2),
(5, 'EN2026005', 'Siddharth Joshi', 'siddharth.joshi@example.com', 3),
(6, 'EN2026006', 'Sneha Deshmukh', 'sneha.deshmukh@example.com', 3),
(7, 'EN2026007', 'Vikram Singh', 'vikram.singh@example.com', 4),
(8, 'EN2026008', 'Neha Gupta', 'neha.gupta@example.com', 4),
(9, 'EN2026009', 'Aditya Mehta', 'aditya.mehta@example.com', 5),
(10, 'EN2026010', 'Pooja Nair', 'pooja.nair@example.com', 5),
(11, 'EN2026011', 'Devansh Rao', 'devansh.rao@example.com', 1),
(12, 'EN2026012', 'Isha Shinde', 'isha.shinde@example.com', 2)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Insert Results (Distributed across Jan to Dec 2026)
INSERT INTO results (student_id, exam_id, marks, total_marks, percentage, status, created_at) VALUES
-- Unit Test 1 (Jan 2026)
(1, 4, 45.00, 50.00, 90.00, 'Pass', '2026-01-15 10:00:00'),
(2, 4, 48.00, 50.00, 96.00, 'Pass', '2026-01-15 10:00:00'),
(3, 4, 32.00, 50.00, 64.00, 'Pass', '2026-01-16 10:00:00'),
(4, 4, 18.00, 50.00, 36.00, 'Fail', '2026-01-16 10:00:00'),

-- Mid-Term Exam (Feb 2026)
(1, 1, 88.50, 100.00, 88.50, 'Pass', '2026-02-20 11:30:00'),
(2, 1, 94.00, 100.00, 94.00, 'Pass', '2026-02-20 11:30:00'),
(3, 1, 72.00, 100.00, 72.00, 'Pass', '2026-02-21 11:30:00'),
(4, 1, 35.00, 100.00, 35.00, 'Fail', '2026-02-21 11:30:00'),
(5, 1, 81.00, 100.00, 81.00, 'Pass', '2026-02-22 11:30:00'),
(6, 1, 65.00, 100.00, 65.00, 'Pass', '2026-02-22 11:30:00'),

-- Unit Test 2 (Mar 2026)
(7, 5, 38.00, 50.00, 76.00, 'Pass', '2026-03-15 09:00:00'),
(8, 5, 29.00, 50.00, 58.00, 'Pass', '2026-03-15 09:00:00'),
(9, 5, 15.00, 50.00, 30.00, 'Fail', '2026-03-16 09:00:00'),
(10, 5, 42.00, 50.00, 84.00, 'Pass', '2026-03-16 09:00:00'),

-- Final Semester Exam (May 2026)
(1, 2, 92.00, 100.00, 92.00, 'Pass', '2026-05-25 14:00:00'),
(2, 2, 97.00, 100.00, 97.00, 'Pass', '2026-05-25 14:00:00'),
(3, 2, 78.00, 100.00, 78.00, 'Pass', '2026-05-26 14:00:00'),
(4, 2, 38.00, 100.00, 38.00, 'Fail', '2026-05-26 14:00:00'),
(5, 2, 89.00, 100.00, 89.00, 'Pass', '2026-05-27 14:00:00'),
(6, 2, 71.00, 100.00, 71.00, 'Pass', '2026-05-27 14:00:00'),
(7, 2, 82.00, 100.00, 82.00, 'Pass', '2026-05-28 14:00:00'),
(8, 2, 64.00, 100.00, 64.00, 'Pass', '2026-05-28 14:00:00'),
(9, 2, 32.00, 100.00, 32.00, 'Fail', '2026-05-29 14:00:00'),
(10, 2, 86.00, 100.00, 86.00, 'Pass', '2026-05-29 14:00:00'),
(11, 2, 85.00, 100.00, 85.00, 'Pass', '2026-05-30 14:00:00'),
(12, 2, 60.00, 100.00, 60.00, 'Pass', '2026-05-30 14:00:00'),

-- Practical Assessment (Jul 2026)
(1, 3, 46.00, 50.00, 92.00, 'Pass', '2026-07-12 11:00:00'),
(2, 3, 49.00, 50.00, 98.00, 'Pass', '2026-07-12 11:00:00'),
(3, 3, 41.00, 50.00, 82.00, 'Pass', '2026-07-13 11:00:00'),
(5, 3, 44.00, 50.00, 88.00, 'Pass', '2026-07-13 11:00:00'),
(7, 3, 40.00, 50.00, 80.00, 'Pass', '2026-07-14 11:00:00'),
(9, 3, 17.00, 50.00, 34.00, 'Fail', '2026-07-14 11:00:00'),

-- Autumn Assessment (Sep 2026)
(1, 6, 91.00, 100.00, 91.00, 'Pass', '2026-09-22 10:00:00'),
(3, 6, 75.00, 100.00, 75.00, 'Pass', '2026-09-22 10:00:00'),
(5, 6, 84.00, 100.00, 84.00, 'Pass', '2026-09-23 10:00:00'),

-- Winter Special Exam (Nov 2026)
(2, 7, 98.00, 100.00, 98.00, 'Pass', '2026-11-28 10:00:00'),
(10, 7, 88.00, 100.00, 88.00, 'Pass', '2026-11-28 10:00:00'),
(11, 7, 83.00, 100.00, 83.00, 'Pass', '2026-11-29 10:00:00')
ON DUPLICATE KEY UPDATE marks=VALUES(marks), percentage=VALUES(percentage), status=VALUES(status);
