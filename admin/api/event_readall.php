<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
require_once('core/eventsModel.php');

//instatiate post
$event = new Event($db);
$user = new Users($db);

//it will check the sent token in header is valid or not
//include_once('checkTokenValidity.php');

//blog post query
$result = $event->read();

//get the row count 
$num = $result->rowCount();

if ($num > 0) {
    $eventArr = array();
    //$eventArr['data'] = array();
    $sno = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $sno++;
        extract($row);
        $eventItem = array(
            'sno' => $sno, 
            'id' => $id,
            'title' => $title,
            'description' => html_entity_decode($description),
            'date' => $date,
            'action' => '<button class="eventEditBtn">Edit</button> <button class="eventDeleteBtn">Delete</button><input type="hidden" value="'.$id.'">'
        );
        array_push($eventArr, $eventItem);
    }
    echo json_encode(array('status'=> '1', 'message'=> 'Success', 'data'=>$eventArr));
} else {
    echo json_encode(array('status'=> '0', 'message' => 'No data found!', 'data'=> array()));
}
