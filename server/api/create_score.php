<?php
// include db connection
include "../database/db_connection.php";
// include error hadnling function
include "../utils/sendServerError.php";

// Define range for score/duration 
define("MAX_SCORE" , 1000);
define("MIN_SCORE" , 0);
// duration in seconds
define("MAX_DURATION" , 1800); // 30 min
define("MIN_DURATION" , 30); // 30 seconds (duh)

// create random values for score/duration
$newScore = mt_rand(MIN_SCORE , MAX_SCORE);
$newDuration = mt_rand(MIN_DURATION , MAX_DURATION);

// initailize response
$response = [];


// receive full name
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data)){
    $fullName = $data["fullName"];
}else{
    $response["success"] = false;
    $response["error"] = "Full name not provided";
    echo json_encode($response);
    exit();
}

// prepare db query
$sql = "INSERT INTO Scores(full_name , score , duration) VALUES(? , ? , ?)";
$query = $mysql->prepare($sql);

if(!$query){
    sendServerError("Server error, please try again" ,$mysql->error);// send user friendly error
}

$query->bind_param("sii" ,$fullName , $newScore , $newDuration);

if(!$query->execute()){
    sendServerError("Server error, please try again", $query->error);
}

// get user's placement
$placementSql = "SELECT COUNT(*) AS rank FROM Scores WHERE score > ? OR (score = ? AND duration < ?)";// checks how many different scores are better than the current one OR are the same but duration is less 
$placementQuery = $mysql->prepare($placementSql);

if(!$placementQuery){
   sendServerError("Server error, please try again" ,$mysql->error);
}

$placementQuery->bind_param("iii", $newScore, $newScore, $newDuration);

if (!$placementQuery->execute()){
    sendServerError("Server error, please try again", $placementQuery->error);
}

$placementResult = $placementQuery->get_result();
$placementRow = $placementResult->fetch_assoc();
$placement = $placementRow["rank"] + 1;// $placementRow["rank"] is number of ranks above me , +1 reaches my rank

$response["success"] = true;
$response["score"] = $newScore;
$response["duration"] = $newDuration;
$response["placement"] = $placement;

echo json_encode($response);
// close query/db_connection
$placementQuery->close();
$query->close();
$mysql->close();
?>