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
require_once('core/eventsModel.php');
require_once('core/userModel.php');
//instatiate user
$user = new Users($db);
$event = new Event($db);

//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data-                      
$data = json_decode(file_get_contents("php://input"));

if($data != null) {
    $event->id = $data->id;
    $event->title = $data->title;
    $event->description = $data->description;
    $event->date = $data->date;
    
    $result = $event->readSingle();
    $row = $result->fetch();
    //get the row count 
    $num = $result->rowCount();
    if($num > 0) {
        
        //$updatedOn = date("yyyy-mm-dd HH:mm:ss");
        $event->title = isset($data->title) ? $data->title : $row['title'];
        $event->description = isset($data->description) ? $data->description : $row['description'];
        $event->date = isset($data->date) ? $data->date : $row['date'];
        
        if ($event->update()) {
            echo json_encode(array('status'=> 1, 'message' => 'Event updated successfully!', 'data'=> array()));
        } else {
            echo json_encode(array('status'=> 0, 'message' => 'Event not updated!', 'data'=> array()));
        }
    } else {
        echo json_encode(array('status'=> 0, 'message' => 'Data not found with given id', 'data'=> array()));
    }
}