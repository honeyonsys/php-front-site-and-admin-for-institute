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
require_once('core/postModel.php');
require_once('core/userModel.php');
//instatiate user
$user = new Users($db);
$post = new Post($db);

//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');
//get raw posted data-                      
$data = json_decode(file_get_contents("php://input"));

if($data != null) {
    $post->id = $data->id;
    $post->category_id = $data->category_id;
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    
    $result = $post->readSingle();
    $row = $result->fetch();
    //get the row count 
    $num = $result->rowCount();
    if($num > 0) {
        
        //$updatedOn = date("yyyy-mm-dd HH:mm:ss");
        $post->title = isset($data->title) ? $data->title : $row['title'];
        $post->category_id = isset($data->category_id) ? $data->category_id : $row['category_id'];
        $post->body = isset($data->body) ? $data->body : $row['body'];
        $post->author = isset($data->author) ? $data->author : $row['author'];
        
        if ($post->update()) {
            echo json_encode(array('status'=> 1, 'message' => 'News updated successfully!', 'data'=> array()));
        } else {
            echo json_encode(array('status'=> 0, 'message' => 'News not updated!', 'data'=> array()));
        }
    } else {
        echo json_encode(array('status'=> 0, 'message' => 'Student not found with given id', 'data'=> array()));
    }
}