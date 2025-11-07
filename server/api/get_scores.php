<?php

// include db connection
include "../database/db_connection.php";
// include error hadnling function
include "../utils/sendServerError.php";


// prepare db query
$sql = "SELECT * FROM Scores ORDER BY score DESC , duration ASC";
$query = $mysql->prepare($sql);

if(!$query){
    sendServerError("Server error, please try again" ,$mysql->error);
}

if(!$query->execute()){
    sendServerError("Server error, please try again" ,$query->error);
}

// fetch result
$result = $query->get_result();
$scores = [];
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $scores[] = $row;
    }
}
$response["success"] = true;
$response["scores"] = $scores;
// send json response
echo json_encode($response);

// close query/db_connection
$query->close();
$mysql->close();
?>