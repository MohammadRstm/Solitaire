<?php 

// db credentials
$db_name = "Solitaire_db";
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_port = 3307;

$mysql = new mysqli($db_host , $db_user ,$db_password , $db_name , $db_port);

// check connection failure
if($mysql->connect_error){
    die("DB CONNECTION FAILED : ". $mysql->connect_error);
}
?>