<?php

// include db connection
include "../db_connection.php";

// prepare db query
$sql = "SELECT * FROM Scores ORDER BY score DESC , duration ASC";
$query = $mysql->prepare($sql);

if(!$query){
    die("QUERY FAILED : " . $mysql->error);
}

if(!$query->execute()){
    die("EXECUTION FAILED : " . $query->error);
}

// fetch result
$result = $query->get_result();
$socres = [];
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $socres[] = $row;
    }
}
// send json response
echo json_encode($socres);

// close query/db_connection
$query->close();
$mysql->close();
?>