<?php
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
include_once('core/config.php');
require_once('core/postModel.php');
require_once('core/userModel.php');

//instatiate post
$post = new Post($db);
$user = new Users($db); //users class is required to validate the token in checkTokenValidity.php
//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//create post
if ($post->create()) {
    echo json_encode(array('message' => 'post created successfully!'));
} else {
    echo json_encode(array('message' => 'post not created!'));
}