<?php
// backend/controllers/ExamController.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Exam.php';
require_once __DIR__ . '/../models/Schedule.php';

class ExamController {
    private $db;
    private $exam;
    private $schedule;
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->exam = new Exam($this->conn);
        $this->schedule = new Schedule($this->conn);
    }

    public function createExam($data) {
        try {
            $this->conn->beginTransaction();

            $this->exam->title = $data['title'];
            $this->exam->subject_id = $data['subject_id'];
            $this->exam->department_id = $data['department_id'];
            $this->exam->semester = $data['semester'];
            $this->exam->year = $data['year'];
            $this->exam->exam_type = $data['exam_type'];
            $this->exam->total_marks = $data['total_marks'] ?? 0;
            $this->exam->passing_marks = $data['passing_marks'];
            $this->exam->instructions = $data['instructions'];
            
            $status = 'Draft';
            if (isset($data['schedule_exam_btn']) || (isset($data['publish_exam']) && $data['publish_exam'] == 'on')) {
                $status = (isset($data['publish_exam']) && $data['publish_exam'] == 'on') ? 'Published' : 'Scheduled';
            }
            $this->exam->status = $status;

            if($this->exam->create()) {
                $exam_id = $this->exam->id;

                // Add questions
                if(!empty($data['question_ids'])) {
                    $qStmt = $this->conn->prepare("INSERT INTO exam_questions (exam_id, question_id) VALUES (?, ?)");
                    foreach ($data['question_ids'] as $q_id) {
                        $qStmt->execute([$exam_id, $q_id]);
                    }
                }

                // Handle Schedule
                if(!empty($data['exam_date']) && !empty($data['start_time']) && !empty($data['end_time'])) {
                    $this->schedule->exam_id = $exam_id;
                    $this->schedule->exam_date = $data['exam_date'];
                    $this->schedule->start_time = $data['start_time'];
                    $this->schedule->end_time = $data['end_time'];
                    $this->schedule->duration = $data['duration'];
                    $this->schedule->create();
                }

                $this->conn->commit();
                return ["status" => "success", "message" => "Exam Created Successfully"];
            }

            $this->conn->rollBack();
            return ["status" => "error", "message" => "Failed to create exam."];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return ["status" => "error", "message" => "Database error: " . $e->getMessage()];
        }
    }

    public function deleteExam($id) {
        $this->exam->id = $id;
        if($this->exam->delete()) {
            return ["status" => "success", "message" => "Exam deleted successfully"];
        }
        return ["status" => "error", "message" => "Failed to delete exam"];
    }

    public function publishExam($id, $current_status) {
        $this->exam->id = $id;
        $new_status = ($current_status === 'Published') ? 'Draft' : 'Published';
        if($this->exam->publish($new_status)) {
            return ["status" => "success", "message" => "Exam status updated to $new_status"];
        }
        return ["status" => "error", "message" => "Failed to update exam status"];
    }
}
?>
