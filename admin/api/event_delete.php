<?php
//ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//to accept the DELETE method the server configuration should be change to accept DELETE
if($_SERVER['REQUEST_METHOD'] !=  'POST') {
    echo json_encode(array('status'=> 0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!', 'data'=> array()));
    exit;
}
//initializing api
include_once('core/config.php');
require_once('core/eventsModel.php');
require_once('core/userModel.php');
//instatiate user
$event = new Event($db);
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data-                      
$data = json_decode(file_get_contents("php://input"));

$event->id = $data->id;

//delete student user
if ($event->delete()) {
    echo json_encode(array('status'=> 1, 'message' => 'Deleted successfully!'));
} else {
    echo json_encode(array('status'=> 0, 'message' => 'Can not delete!'));
}
?>