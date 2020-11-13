<?php

require_once("config.php");
require_once("saveData.php");
require_once("verifyUser.php");

$postData = json_decode(file_get_contents('php://input'));
$call = $postData->call;
$payload = $postData->payload;

switch ($call) {
    case 'transferData':
        writeData($mysqli, $payload);
        break;
    
    default:
        # code...
        break;
}

$sql->close();