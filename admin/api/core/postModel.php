<?php

class Post
{
    //database variables
    private $conn;
    private $table = 'posts';

    //post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // connecting to database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //getting posts from database
    public function read()
    {
        $query = 'SELECT p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM ' . $this->table . ' p ORDER BY p.created_at DESC';

        //prepare statement 
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }

    public function readSingle()
    {
        $query = 'SELECT p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM ' . $this->table . ' p WHERE p.id = ? LIMIT 1';

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
        $query = 'INSERT INTO ' . $this->table . ' (title, body, author, category_id, created_at) VALUES(:title, :body, :author, :category_id, :created_at)';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created_at = date("Y-m-d h:i:s");

        //binding of parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':created_at', $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        //clean data 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding of parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    //delete record function
    public function deletePost()
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