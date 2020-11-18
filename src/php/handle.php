<?php

require_once("config.php");
require_once("saveData.php");
require_once("verifyUser.php");

$postData = json_decode(file_get_contents('php://input'));
$validuser = true;
$call = $postData->call;
$payload = $postData->payload;

switch ($call) {
    case 'transferData':
        $payload->datum = date("Y-m-d");
        $payload->zeit = date("H:i:s:v");
        $validuser = checkuser($mysqli, $payload);
        if($validuser) writeData($mysqli, $payload);
        break;
    
    default:
        # code...
        break;
}
