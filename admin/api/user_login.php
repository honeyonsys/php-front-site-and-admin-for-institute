<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if($_SERVER['REQUEST_METHOD'] !=  'POST') {
    echo json_encode(array('status'=> 0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!', 'data'=> array()));
    exit;
}
//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
//instatiate user
$user = new Users($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));
$user->email = $data->email;
$user->password = $data->password;

if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array('status'=> 0, 'message' => 'Not a valid email!'));
} else {
    if ($user->loginUser()) {
        $tokenRes = $user->generateTokenForEmail($user->email);
        $decodeRes = json_decode($tokenRes);
        echo json_encode(array('status'=> 1, 'message' => 'user login successfully!', 'token'=>$decodeRes->token, 'tokenExpire'=>$decodeRes->tokenExpire));
        
    } else {
        echo json_encode(array('status'=> 0, 'message' => 'user login failed!'));
    }
}

?>