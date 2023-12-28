<?php
session_start();
session_regenerate_id(true);
// change the information according to your database
$db_connection = mysqli_connect("localhost","root","","clothing_store");
// CHECK DATABASE CONNECTION
if(mysqli_connect_errno()){
    echo "Connection Failed".mysqli_connect_error();
    exit;
}