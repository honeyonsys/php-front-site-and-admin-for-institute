<?php
//Other Constants
defined('REG_USER_EMAIL_SUBJECT') ? null : define('REG_USER_EMAIL_SUBJECT', 'Verify your email for REST API');
defined('SITE_URL') ? null : define('SITE_URL', 'http://localhost/institute-management-system-backend');


//DB Credentials
define('DBNAME', 'ims');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBHOST', 'localhost');
define('APPNAME', 'REST API');

$db = new PDO('mysql:host=localhost; dbname=' . DBNAME . ';charset=utf8', DBUSER, DBPASS);

//sessing up db attributes
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>