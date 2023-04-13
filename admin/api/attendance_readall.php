<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
require_once('core/attendanceModel.php');

//instatiate post
$attendance = new Attendance($db);
$user = new Users($db);

//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
$attendance->userId = isset($_GET['user_id']) ? $_GET['user_id'] : "";
$attendance->date = isset($_GET['date']) ? $_GET['date'] : "";

$result = $attendance->readAllAttendance();

//get the row count 
$num = $result->rowCount();

if ($num > 0) {
    $attendanceArr = array();
    //$postArr['data'] = array();
    $sno = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $sno++;
        extract($row);
        $attendanceItem = array(
            'id' => $id,
            'user_id' => $userId,
            'date' => $date,
            'attendance' => $attendance,
            'action' => '<button>Edit</button>'
        );
        array_push($attendanceArr, $attendanceItem);
    }
    echo json_encode(array('status'=> '1', 'message'=> 'Success', 'data'=>$attendanceArr));
} else {
    echo json_encode(array('status'=> 0, 'message' => 'No post found!', 'data'=> array()));
}
