<?php
//ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if($_SERVER['REQUEST_METHOD'] !=  'POST') {
    echo json_encode(array('status'=>0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!', 'data'=>array()));
    exit;
}
//initializing api
include_once('../core/config.php');
require_once('../core/userModel.php');
//instatiate user
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$createdOn = date("yy-mm-dd HH:mm:ss");
$user->name = $data->name;
$user->dob = $data->dob;
$user->phone = $data->phone;
$user->address = $data->address;
$user->courseId = $data->courseId;
$user->createdOn = $createdOn;
$user->updatedOn = $createdOn;
$user->status = 0;
$user->email = $data->email;
$user->password = md5(rand());
$user->type = 0;


if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array('status'=> 0, 'message' => 'Not a valid email!', 'data'=> array()));
} else {
    if($user->checkIfEmailAlreadyRegistered()) {
        echo json_encode(array('status'=> 0, 'message' => 'email '. $user->email .' is already registered!', 'data'=> array()));
    } else {
    if ($user->createUser()) {
            echo json_encode(array('status'=> 1, 'message' => 'Student created successfully!', 'data'=> array()));
        } else {
            echo json_encode(array('status'=> 0, 'message' => 'Student creation failed!', 'data'=> array()));
        }
    }
}

?>