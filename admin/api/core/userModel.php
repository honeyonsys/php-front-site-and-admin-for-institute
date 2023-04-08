<?php

class Users
{
    //database variables
    private $conn;
    private $table = 'users';

    //post properties
    public $id;
    public $name;
    public $dob;
    public $phone;
    public $address;
    public $courseId;
    public $createdOn;
    public $updatedOn;
    public $status;
    public $email;
    public $password;
    public $type;
    public $token;
    public $tokenExpire;

    // connecting to database
    public function __construct($db)
    {
        $this->conn = $db;
    }
    //function to check if a email is already rregistered
    public function checkIfEmailAlreadyRegistered()
    {
        $selectQry = 'SELECT id FROM ' . $this->table . ' WHERE email = ?';

        //prepare statement 
        $stmt = $this->conn->prepare($selectQry);
        //bind param
        $stmt->bindParam(1, $this->email);
        //execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers(){
        //0 = student
        //1 = admin
        //2 = teacher
        $selectQry = 'SELECT * FROM ' . $this->table . ' WHERE `type`= ?';

        //prepare statement 
        $stmt = $this->conn->prepare($selectQry);
        //bind param
        $stmt->bindParam(1, $this->type);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    public function getSingleUser(){
        $selectQry = 'SELECT * FROM ' . $this->table . ' WHERE `type`=? and `id`= ?';
        $stmt = $this->conn->prepare($selectQry);
        $stmt->bindParam(1, $this->type);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function createUser()
    {
        $insertQry = 'INSERT INTO ' . $this->table . '(email, password, name, dob, phone, address, courseId, createdOn, updatedOn, type) VALUES(:email, :password, :name, :dob, :phone, :address, :courseId, :createdOn, :updatedOn, :type)';
        $stmt = $this->conn->prepare($insertQry);
        //clean data 
        
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = md5(htmlspecialchars(strip_tags($this->password)));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->courseId = htmlspecialchars(strip_tags($this->courseId));
        $this->createdOn = htmlspecialchars(strip_tags($this->createdOn));
        $this->updatedOn = htmlspecialchars(strip_tags($this->updatedOn));
        $this->type = htmlspecialchars(strip_tags($this->type));

        //binding of parameters
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':dob', $this->dob);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':courseId', $this->courseId);
        $stmt->bindParam(':createdOn', $this->createdOn);
        $stmt->bindParam(':updatedOn', $this->updatedOn);
        $stmt->bindParam(':type', $this->type);

        if ($stmt->execute()) {
            $insertedId = $this->conn->lastInsertId();
            $messageEmail = 'Please verify your email by click on the below link \n';
            $messageEmail .= '<a href="' . SITE_URL . '/api/users/verifyEmail.php?ref=' . base64_encode($insertedId) . '">VERIFY YOUR EMAIL</a>';
            mail($this->email, REG_USER_EMAIL_SUBJECT, $messageEmail);
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function updateUser() 
    {
        $updateQry = 'UPDATE ' . $this->table . ' SET name = :name, dob = :dob, phone = :phone, address = :address, courseId = :courseId, updatedOn = :updatedOn, password = :password WHERE id = :id';

        $stmt = $this->conn->prepare($updateQry);
        //clean data 
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->courseId = htmlspecialchars(strip_tags($this->courseId));
        $this->updatedOn = htmlspecialchars(strip_tags($this->updatedOn));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->type = htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':dob', $this->dob);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':courseId', $this->courseId);
        $stmt->bindParam(':updatedOn', $this->updatedOn);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function deleteUser()
    {
        $delQuery = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($delQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong 
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    public function loginUser()
    {
        //TODO: add a token into the table while successfull login and add a time stamp for next one hour
        $selectQry = 'SELECT id, email  FROM ' . $this->table . ' WHERE email = ? AND password = ?';

        //prepare statement 
        $stmt = $this->conn->prepare($selectQry);
        //bind param
        $encryptPassword = md5($this->password);
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $encryptPassword);
        //execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function validateToken() {
        $selectQry = "SELECT tokenExpire FROM " .$this->table . ' WHERE token = :token';
        $stmt = $this->conn->prepare($selectQry);
        //clean data 
        $stmt->bindParam(':token', $this->token);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $rowData = $stmt->fetch();
            $tokenExpire = $rowData['tokenExpire'];
            
            if($tokenExpire > time()) {
                return true;
            } else {
                return false;
            }
            
        }
    }

    public function generateTokenForEmail($email) {
        $timeStamp = time() + 900; //adding 30 more minutes
        $tokenString = $email.",". $timeStamp;
        $encodedString = base64_encode($tokenString);
        $updateQry = 'UPDATE ' .$this->table. ' SET token = :token, tokenExpire = :tokenExpire WHERE email = :email';

        $stmt = $this->conn->prepare($updateQry);
        //clean data 
        $this->token = htmlspecialchars(strip_tags($encodedString));
        $this->tokenExpire = htmlspecialchars(strip_tags($timeStamp));
        $this->email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':tokenExpire', $this->tokenExpire);
        $stmt->bindParam(':email', $this->email);
        if ($stmt->execute()) {
            return json_encode(array("token"=>$encodedString, "tokenExpire"=>$timeStamp));
        } else {
            return json_encode(array("token"=> "", "tokenExpire"=>""));
        }
              
    }

  
}
?>