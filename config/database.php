<?php 

 $hostname = "localhost";
$tablename = "harpreet_task";
$dbname = "root";
$dbpassword = "";

$conn = new mysqli($hostname, $dbname, $dbpassword,$tablename);
if(!$conn){
    echo "Connection Failed";
    exit;
}
$timezone = new DateTimeZone('Asia/Kolkata');   
$date =  new DateTime('now',$timezone);
 ?>