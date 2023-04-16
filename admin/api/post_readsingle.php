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
require_once('core/postModel.php');
//instatiate user
$post = new Post($db);
$user = new Users($db);
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');

$post->id = $_GET['id'];


$result = $post->readSingle();
$row = $result->fetch();
$num = $result->rowCount();
if($num > 0) {
    $postArr = array(
        'id' => $row['id'],
        'category_id' => $row['category_id'],
        'title' => $row['title'],
        'body' => $row['body'],
        'author' => $row['author'],
        'created_at' => $row['created_at'],

    );
    echo json_encode(array('status'=> 1,'message'=> 'Success', 'data'=> $postArr));
} else {
    echo json_encode(array('status'=> 0,'message'=> 'There is no data', 'data'=> array()));
}



?>