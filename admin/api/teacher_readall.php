<?php
//ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if($_SERVER['REQUEST_METHOD'] !=  'GET') {
    echo json_encode(array('status'=> 0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!'));
    exit;
}
//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
//instatiate user
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
$user->type = 2;
//blog post 
$result = $user->getAllUsers();

//get the row count 
$num = $result->rowCount();

if ($num > 0) {
    $userArr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $userItem = array(
            'id' => $id,
            'name' => $name,
            'dob' => $dob,
            'phone' => $phone,
            'address' => $address,
            'courseId' => $courseId,
            'createdOn' => $createdOn,
            'updatedOn' => $updatedOn,
            'status' => $status,
            'email' => $email,
            'type' => $type
        );
        array_push($userArr, $userItem);
    }
    echo json_encode(array('status'=> '1', 'message'=> 'Success', 'data'=>$userArr));
} else {
    echo json_encode(array('status'=> 0, 'message' => 'No post found!', 'data'=> array()));
}
