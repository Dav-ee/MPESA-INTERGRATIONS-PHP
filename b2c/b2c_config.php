<?php
 date_default_timezone_set('Africa/Nairobi');

 define("DB_HOST","localhost");
define("DB_USER","##");
define("DB_PASS","##");
define("DB_NAME","##");

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$conn){
    die("hey db not connected");
}
?>