<?php
//ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if($_SERVER['REQUEST_METHOD'] !=  'PUT') {
    echo json_encode(array('status'=> 0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!', 'data'=> array()));
    exit;
}
//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
//instatiate user
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data-                      
$data = json_decode(file_get_contents("php://input"));

if($data != null) {
    $user->type = 2;
    $user->id = $data->id;
    $result = $user->getSingleUser();
    $row = $result->fetch();
    //get the row count 
    $num = $result->rowCount();
    if($num > 0) {
        
        $updatedOn = date("yyyy-mm-dd HH:mm:ss");
        $user->name = isset($data->name) ? $data->name : $row['name'];
        $user->dob = isset($data->dob) ? $data->dob : $row['dob'];
        $user->phone = isset($data->phone) ? $data->phone : $row['phone'];
        $user->address = isset($data->address) ? $data->address : $row['address'];
        $user->courseId = isset($data->courseId) ? $data->courseId : $row['courseId'];
        $user->updatedOn = $updatedOn;
        $user->password = isset($data->password) ? md5($data->password) : $row['password'];

        if ($user->updateUser()) {
            echo json_encode(array('status'=> 1, 'message' => 'Teacher updated successfully!', 'data'=> array()));
        } else {
            echo json_encode(array('status'=> 0, 'message' => 'Teacher not updated!', 'data'=> array()));
        }
    } else {
        echo json_encode(array('status'=> 0, 'message' => 'Teacher not found with given id', 'data'=> array()));
    }
    
}

