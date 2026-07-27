<?php
// controllers/ExamController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ExamMaster.php';
require_once __DIR__ . '/../models/ExamQuestion.php';
require_once __DIR__ . '/../models/ExamSchedule.php';
require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../models/Subject.php';

class ExamController {
    private $db;
    private $examMaster;
    private $examQuestion;
    private $examSchedule;
    private $department;
    private $subject;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->examMaster = new ExamMaster($this->db);
        $this->examQuestion = new ExamQuestion($this->db);
        $this->examSchedule = new ExamSchedule($this->db);
        $this->department = new Department($this->db);
        $this->subject = new Subject($this->db);
    }

    public function getAllExams() {
        $stmt = $this->examMaster->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExamList() {
        $query = "
            SELECT e.id, e.title, s.name as subject_name, e.status, 
                   (SELECT COUNT(*) FROM exam_questions eq WHERE eq.exam_id = e.id) as total_questions,
                   es.exam_date, e.duration_minutes as duration
            FROM exam_master e
            JOIN subjects s ON e.subject_id = s.id
            LEFT JOIN exam_schedule es ON e.id = es.exam_id
            ORDER BY e.created_at DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExamById($id) {
        $this->examMaster->id = $id;
        return $this->examMaster->readOne();
    }

    public function getDepartments() {
        $stmt = $this->department->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubjects() {
        $stmt = $this->subject->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createExam($data) {
        try {
            $this->db->beginTransaction();

            // 1. Create Exam Master
            $this->examMaster->title = $data['title'];
            $this->examMaster->department_id = $data['department_id'];
            $this->examMaster->subject_id = $data['subject_id'];
            $this->examMaster->semester = $data['semester'];
            $this->examMaster->year = $data['year'];
            $this->examMaster->exam_type = $data['exam_type'];
            $this->examMaster->total_marks = $data['total_marks'];
            $this->examMaster->passing_marks = $data['passing_marks'];
            
            // Calculate duration if start/end time provided
            $duration = 0;
            if(!empty($data['start_time']) && !empty($data['end_time'])) {
                $start = strtotime($data['start_time']);
                $end = strtotime($data['end_time']);
                $duration = round(abs($end - $start) / 60,2);
            }
            $this->examMaster->duration_minutes = $duration;

            // Determine Status
            if (isset($data['publish_exam'])) {
                $status = 'Published';
            } elseif (isset($data['save_draft'])) {
                $status = 'Draft';
            } else {
                $status = 'Scheduled'; // If schedule_exam_btn was clicked and it's not published
            }
            $this->examMaster->status = $status;
            $this->examMaster->created_by = $_SESSION['admin_id'] ?? 1;

            $exam_id = $this->examMaster->create();

            if(!$exam_id) {
                throw new Exception("Failed to create Exam Master record.");
            }

            // 2. Add Questions
            if(isset($data['question_ids']) && is_array($data['question_ids'])) {
                foreach($data['question_ids'] as $q_id) {
                    $this->examQuestion->exam_id = $exam_id;
                    $this->examQuestion->question_id = $q_id;
                    $this->examQuestion->create();
                }
            }

            // 3. Add Schedule
            if(!empty($data['exam_date']) || !empty($data['start_time']) || !empty($data['end_time'])) {
                $this->examSchedule->exam_id = $exam_id;
                $this->examSchedule->exam_date = !empty($data['exam_date']) ? $data['exam_date'] : null;
                $this->examSchedule->start_time = !empty($data['start_time']) ? $data['start_time'] : null;
                $this->examSchedule->end_time = !empty($data['end_time']) ? $data['end_time'] : null;
                $this->examSchedule->room_no = $data['room_no'] ?? null;
                $this->examSchedule->invigilator_name = $data['invigilator_name'] ?? null;
                $this->examSchedule->instructions = $data['instructions'] ?? null;
                $this->examSchedule->create();
            }

            $this->db->commit();
            return ['status' => true, 'message' => "Exam created successfully!"];

        } catch(Exception $e) {
            $this->db->rollBack();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
?>
