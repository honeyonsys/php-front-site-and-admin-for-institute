<?php
//checking if the session is exist then redirecing to dashboard.php else login.php
if(isset($_SESSION['institute'])) {
    header("location: dashboard.php");
} else {
    header("location: login.php");
}