<?php 
 session_start();
 if(!isset($_SESSION['email']) || !isset($_SESSION['user_id']) ){
    echo json_encode(["error"=>"Login Are Required", "message" => "Somthing are Wrong"]);
    die();
 }