<?php

class Event
{
    //database variables
    private $conn;
    private $table = 'events';

    //post properties
    public $id;
    public $title;
    public $description;
    public $date;

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
        $query = 'INSERT INTO ' . $this->table . ' (title, description, date) VALUES(:title, :description, :date)';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date = htmlspecialchars(strip_tags($this->date));
        
        //binding of parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        
        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET title = :title, description = :description, date = :date WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding of parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
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