<?php
//cheking that the "token" sent in the headers is valid or not
//NOTE: before adding this code to any api the user class should be assign to $user variable
if (isset($_SERVER['HTTP_TOKEN'])) {
    $user->token = $_SERVER['HTTP_TOKEN'];
    if(!$user->validateToken()) {
        echo json_encode(array('status'=> 0, 'message' => 'token is not valid'));    
        exit;
    }
} else {
    echo json_encode(array('status'=> 0, 'message' => 'token is missing in headers'));
    exit;
}
?>