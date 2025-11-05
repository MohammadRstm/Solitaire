<?php
// include db connection
include "db_connection.php";

// Define range for score/duration 
define("MAX_SCORE" , 1000);
define("MIN_SCORE" , 0);
// duration in seconds
define("MAX_DURATION" , 1800); // 30 min
define("MIN_DURATION" , 30); // 30 seconds (duh)

// create random values for score/duration
$newScore = mt_rand(MIN_SCORE , MAX_SCORE);
$newDuration = mt_rand(MIN_DURATION , MAX_DURATION);

// receive full name
$fullName = $_POST["fullName"];

if(!$fullName)
    $fullName = "Anonymous";

// prepare db query
$sql = "INSERT INTO Scores(full_name , score , duration) VALUES(? , ? , ?)";
$query = $mysql->prepare($sql);

if(!$query){
    die("QUERY FAILED : " . $mysql->error);
}

$query->bind_param("sii" ,$fullName , $newScore , $newDuration);

if(!$query->execute()){
    die("EXECUTION FAILED : " . $query->error);
}

// close query/db_connection
$query->close();
$mysql->close();
?>