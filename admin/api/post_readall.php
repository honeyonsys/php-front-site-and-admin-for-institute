<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('core/config.php');
require_once('core/userModel.php');
require_once('core/postModel.php');

//instatiate post
$post = new Post($db);
$user = new Users($db);

//it will check the sent token in header is valid or not
include_once('checkTokenValidity.php');

//blog post query
$result = $post->read();

//get the row count 
$num = $result->rowCount();

if ($num > 0) {
    $postArr = array();
    //$postArr['data'] = array();
    $sno = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $sno++;
        extract($row);
        $postItem = array(
            'sno' => $sno, 
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'categoryId' => $category_id,
            'categoryName' => '',
            'createdAt' => $created_at,
            'action' => '<button class="newsEditBtn">Edit</button> <button class="newsDeleteBtn">Delete</button><input type="hidden" value="'.$id.'">'
        );
        array_push($postArr, $postItem);
    }
    echo json_encode(array('status'=> '1', 'message'=> 'Success', 'data'=>$postArr));
} else {
    echo json_encode(array('status'=> 0, 'message' => 'No post found!', 'data'=> array()));
}
