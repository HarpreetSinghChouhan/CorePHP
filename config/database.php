<?php 

 $hostname = "localhost";
$databasename = "harpreet_task";
$dbname = "root";
$dbpassword = "";

$conn = new mysqli($hostname, $dbname, $dbpassword,$databasename);
if(!$conn){
    echo "Connection Failed";
    exit;
}
$timezone = new DateTimeZone('Asia/Kolkata');   
$date =  new DateTime('now',$timezone);
 ?>