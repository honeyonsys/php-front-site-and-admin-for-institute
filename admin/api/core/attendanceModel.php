<?php
class Attendance 
{
    //database variables
    private $conn;
    private $table = 'attendance';

    public $id;
    public $userId;
    public $date;
    public $attendance;

    // connecting to database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function checkIfAttendanceAlreadyMarked() {
        $selectQry = "SELECT * FROM " . $this->table . " WHERE user_id = :userId AND date = :date";
        $stmt = $this->conn->prepare($selectQry);
        //bind param
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":date", $this->date);
        //execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function create() {
        $insertQry = "INSERT INTO " . $this->table . " (user_id, date, attendance) VALUES(:userId, :date, :attendance)";
        $stmt = $this->conn->prepare($insertQry);
        //clean data 
        
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':attendance', $this->attendance);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function update() {
        $updateQry = "UPDATE " . $this->table ." SET attendance = :attendance WHERE user_id = :userId AND date = :date";
        $stmt = $this->conn->prepare($updateQry);
        $stmt->bindParam(':attendance', $this->attendance);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':date', $this->date);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function readAllAttendance() {
        $whereClause = " WHERE attendance < '2'";
        if($this->userId != "") {
            $whereClause = " AND user_id = :userId";
        }
        if($this->date != "") {
            $whereClause = " AND date = :date";
        }
        $selectQry = "SELECT * FROM " . $this->table . $whereClause;
        $stmt = $this->conn->prepare($selectQry);
        if(isset($_GET['user_id'])) {
            $stmt->bindParam(":userId", $this->userId);
        }
        if(isset($_GET['date'])) {
            $stmt->bindParam(":date", $this->date);
        }
        //execute query
        $stmt->execute();
        return $stmt;
    }

}