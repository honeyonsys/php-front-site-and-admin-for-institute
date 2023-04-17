<?php

class Notice
{
    //database variables
    private $conn;
    private $table = 'notice';

    //post properties
    public $id;
    public $notice;


    // connecting to database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //getting posts from database
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table . ' e ORDER BY e.id DESC';

        //prepare statement 
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }

    public function readSingle()
    {
        $query = 'SELECT * FROM ' . $this->table . ' e WHERE e.id = ? LIMIT 1';

        //prepare statement 
        $stmt = $this->conn->prepare($query);
        //bind param
        $stmt->bindParam(1, $this->id);
        //execute query
        $stmt->execute();
        return $stmt;
        
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (notice) VALUES(:notice)';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->notice = htmlspecialchars(strip_tags($this->notice));
            
        //binding of parameters
        $stmt->bindParam(':notice', $this->notice);
        
        
        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET notice = :notice WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->notice = htmlspecialchars(strip_tags($this->notice));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding of parameters
        $stmt->bindParam(':notice', $this->notice);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //delete record function
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }
}