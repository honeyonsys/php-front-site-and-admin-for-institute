<?php
//ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if($_SERVER['REQUEST_METHOD'] !=  'GET') {
    echo json_encode(array('status'=> 0, 'message' => $_SERVER['REQUEST_METHOD']. ' method not suppoting in this endpoint!', 'data'=> array()));
    exit;
}

if(!isset($_GET['id'])) {
    echo json_encode(array('status'=> 0, 'message'=> '"id" parameter is required', 'data'=> array()));
    exit;
}
//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
require_once('core/eventsModel.php');
//instatiate user
$event = new Event($db);
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');

$event->id = $_GET['id'];


$result = $event->readSingle();
$row = $result->fetch();
$num = $result->rowCount();
if($num > 0) {
    $eventArr = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'date' => $row['date']
    );
    echo json_encode(array('status'=> 1,'message'=> 'Success', 'data'=> $eventArr));
} else {
    echo json_encode(array('status'=> 0,'message'=> 'There is no data', 'data'=> array()));
}



?>