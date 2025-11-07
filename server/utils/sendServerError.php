<?php
function sendServerError($message , $error = null, $code = 500){// default http code to Internal server error
    http_response_code($code);
    echo json_encode([
        "success" => false,
        "message" => $message,
        "error" => $error
    ]);
   exit();
}
?>