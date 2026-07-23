-- ============================================================
-- ExamShield LPS — Admin Module Database Schema
-- Run this in phpMyAdmin → examshield database
-- All tables use IF NOT EXISTS — safe to run multiple times
-- ============================================================

USE examshield;

-- ──────────────────────────────────────────────────────────
-- 1. COURSES
--    Linked to departments. A department has many courses.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS courses (
    id              INT(11)         NOT NULL AUTO_INCREMENT,
    course_name     VARCHAR(150)    NOT NULL,
    course_code     VARCHAR(20)     DEFAULT NULL,
    department_id   INT(11)         NOT NULL,
    description     TEXT            DEFAULT NULL,
    duration_years  TINYINT(2)      DEFAULT 3,
    status          ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    created_by      INT(11)         DEFAULT NULL,
    created_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_course_code (course_code),
    KEY fk_course_department (department_id),
    KEY fk_course_created_by (created_by),

    CONSTRAINT fk_course_department
        FOREIGN KEY (department_id) REFERENCES departments (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_course_created_by
        FOREIGN KEY (created_by) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 2. SUBJECTS
--    Linked to courses and departments.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS subjects (
    id              INT(11)         NOT NULL AUTO_INCREMENT,
    subject_name    VARCHAR(150)    NOT NULL,
    subject_code    VARCHAR(20)     DEFAULT NULL,
    course_id       INT(11)         NOT NULL,
    department_id   INT(11)         NOT NULL,
    credit_hours    TINYINT(2)      DEFAULT 3,
    semester        TINYINT(2)      DEFAULT NULL COMMENT 'Semester number (1-8)',
    description     TEXT            DEFAULT NULL,
    status          ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    created_by      INT(11)         DEFAULT NULL,
    created_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_subject_code (subject_code),
    KEY fk_subject_course (course_id),
    KEY fk_subject_department (department_id),
    KEY fk_subject_created_by (created_by),

    CONSTRAINT fk_subject_course
        FOREIGN KEY (course_id) REFERENCES courses (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_subject_department
        FOREIGN KEY (department_id) REFERENCES departments (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_subject_created_by
        FOREIGN KEY (created_by) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 3. QUESTIONS (Question Bank)
--    Multiple-choice questions linked to subjects.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS questions (
    id              INT(11)         NOT NULL AUTO_INCREMENT,
    subject_id      INT(11)         NOT NULL,
    question_text   TEXT            NOT NULL,
    option_a        VARCHAR(500)    NOT NULL,
    option_b        VARCHAR(500)    NOT NULL,
    option_c        VARCHAR(500)    NOT NULL,
    option_d        VARCHAR(500)    NOT NULL,
    correct_option  ENUM('A','B','C','D') NOT NULL,
    explanation     TEXT            DEFAULT NULL COMMENT 'Optional explanation for the correct answer',
    difficulty      ENUM('EASY','MEDIUM','HARD') NOT NULL DEFAULT 'MEDIUM',
    marks           DECIMAL(5,2)    NOT NULL DEFAULT 1.00,
    is_active       TINYINT(1)      NOT NULL DEFAULT 1,
    created_by      INT(11)         DEFAULT NULL,
    created_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY fk_question_subject (subject_id),
    KEY fk_question_created_by (created_by),
    KEY idx_question_difficulty (difficulty),
    KEY idx_question_active (is_active),

    CONSTRAINT fk_question_subject
        FOREIGN KEY (subject_id) REFERENCES subjects (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_question_created_by
        FOREIGN KEY (created_by) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 4. EXAMS
--    Scheduled exam sessions.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS exams (
    id                  INT(11)         NOT NULL AUTO_INCREMENT,
    exam_title          VARCHAR(200)    NOT NULL,
    subject_id          INT(11)         NOT NULL,
    course_id           INT(11)         NOT NULL,
    department_id       INT(11)         NOT NULL,
    exam_date           DATE            NOT NULL,
    start_time          TIME            NOT NULL,
    duration_minutes    INT(4)          NOT NULL DEFAULT 60,
    total_marks         DECIMAL(6,2)    NOT NULL DEFAULT 100.00,
    pass_marks          DECIMAL(6,2)    NOT NULL DEFAULT 40.00,
    max_attempts        TINYINT(2)      NOT NULL DEFAULT 1,
    instructions        TEXT            DEFAULT NULL,
    status              ENUM('DRAFT','SCHEDULED','LIVE','COMPLETED','CANCELLED')
                                        NOT NULL DEFAULT 'DRAFT',
    created_by          INT(11)         DEFAULT NULL,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY fk_exam_subject (subject_id),
    KEY fk_exam_course (course_id),
    KEY fk_exam_department (department_id),
    KEY fk_exam_created_by (created_by),
    KEY idx_exam_date (exam_date),
    KEY idx_exam_status (status),

    CONSTRAINT fk_exam_subject
        FOREIGN KEY (subject_id) REFERENCES subjects (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_exam_course
        FOREIGN KEY (course_id) REFERENCES courses (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_exam_department
        FOREIGN KEY (department_id) REFERENCES departments (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_exam_created_by
        FOREIGN KEY (created_by) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 5. EXAM_FACULTY (Pivot)
--    Assigns faculty members as invigilators to exams.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS exam_faculty (
    id          INT(11)     NOT NULL AUTO_INCREMENT,
    exam_id     INT(11)     NOT NULL,
    faculty_id  INT(11)     NOT NULL,
    assigned_at TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_exam_faculty (exam_id, faculty_id),
    KEY fk_ef_exam (exam_id),
    KEY fk_ef_faculty (faculty_id),

    CONSTRAINT fk_ef_exam
        FOREIGN KEY (exam_id) REFERENCES exams (id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_ef_faculty
        FOREIGN KEY (faculty_id) REFERENCES users (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 6. EXAM_QUESTIONS (Pivot)
--    Links specific questions to an exam.
--    Allows reusing questions across multiple exams.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS exam_questions (
    id           INT(11)  NOT NULL AUTO_INCREMENT,
    exam_id      INT(11)  NOT NULL,
    question_id  INT(11)  NOT NULL,
    order_no     INT(4)   NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_exam_question (exam_id, question_id),
    KEY fk_eq_exam (exam_id),
    KEY fk_eq_question (question_id),

    CONSTRAINT fk_eq_exam
        FOREIGN KEY (exam_id) REFERENCES exams (id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_eq_question
        FOREIGN KEY (question_id) REFERENCES questions (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 7. NOTIFICATIONS
--    System notifications targeted to roles or all users.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS notifications (
    id              INT(11)     NOT NULL AUTO_INCREMENT,
    title           VARCHAR(200) NOT NULL,
    message         TEXT        NOT NULL,
    target_role     ENUM('ALL','ADMIN','FACULTY','STUDENT') NOT NULL DEFAULT 'ALL',
    department_id   INT(11)     DEFAULT NULL COMMENT 'NULL = all departments',
    created_by      INT(11)     DEFAULT NULL,
    created_at      TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY fk_notif_created_by (created_by),
    KEY fk_notif_department (department_id),
    KEY idx_notif_role (target_role),

    CONSTRAINT fk_notif_created_by
        FOREIGN KEY (created_by) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    CONSTRAINT fk_notif_department
        FOREIGN KEY (department_id) REFERENCES departments (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- 8. NOTIFICATION_READS (Pivot)
--    Tracks which users have read which notifications.
-- ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS notification_reads (
    id              INT(11)     NOT NULL AUTO_INCREMENT,
    notification_id INT(11)     NOT NULL,
    user_id         INT(11)     NOT NULL,
    read_at         TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_notif_read (notification_id, user_id),
    KEY fk_nr_notification (notification_id),
    KEY fk_nr_user (user_id),

    CONSTRAINT fk_nr_notification
        FOREIGN KEY (notification_id) REFERENCES notifications (id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_nr_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ──────────────────────────────────────────────────────────
-- OPTIONAL: Add columns to existing `users` table
-- Only run if these columns do not already exist.
-- ──────────────────────────────────────────────────────────

-- Enrollment number for students
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS enrollment_no  VARCHAR(50)  DEFAULT NULL COMMENT 'Student enrollment number',
    ADD COLUMN IF NOT EXISTS semester       TINYINT(2)   DEFAULT NULL COMMENT 'Current semester (students)',
    ADD COLUMN IF NOT EXISTS phone          VARCHAR(20)  DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS gender         ENUM('MALE','FEMALE','OTHER') DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS date_of_birth  DATE         DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS address        TEXT         DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS avatar         VARCHAR(255) DEFAULT NULL COMMENT 'Relative path to avatar image',
    ADD COLUMN IF NOT EXISTS updated_at     TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


-- ──────────────────────────────────────────────────────────
-- SAMPLE DATA (optional — comment out if not needed)
-- ──────────────────────────────────────────────────────────

-- Sample department (only if departments table is empty)
-- INSERT IGNORE INTO departments (department_name) VALUES
--     ('Computer Engineering'),
--     ('Information Technology'),
--     ('Electronics'),
--     ('Mechanical Engineering');

-- ============================================================
-- Schema complete. Run in phpMyAdmin on the `examshield` DB.
-- ============================================================
