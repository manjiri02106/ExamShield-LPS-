<?php
// models/Subject.php

class Subject {
    private $conn;
    private $table_name = "subjects";

    public $id;
    public $department_id;
    public $name;
    public $code;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByDepartment($dept_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE department_id = ? ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $dept_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->name = $row['name'];
            $this->department_id = $row['department_id'];
            $this->code = $row['code'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, department_id=:department_id, code=:code";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->department_id = htmlspecialchars(strip_tags($this->department_id));
        $this->code = htmlspecialchars(strip_tags($this->code));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":department_id", $this->department_id);
        $stmt->bindParam(":code", $this->code);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, department_id=:department_id, code=:code WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->department_id = htmlspecialchars(strip_tags($this->department_id));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":department_id", $this->department_id);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
