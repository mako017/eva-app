<?php

require_once "config.php";
require_once "saveData.php";
require_once "verifyUser.php";
require_once "courseData.php";

$postData = json_decode(file_get_contents("php://input"));
$validuser = true;
$call = $postData->call;
$payload = isset($postData->payload) ? $postData->payload : 0;

switch ($call) {
	case "transferData":
		$payload->datum = date("Y-m-d");
		$payload->zeit = date("H:i:s:v");
		$validuser = checkuser($mysqli, $payload);
		if ($validuser) {
			writeData($mysqli, $payload);
		}
		break;
	case "requestAllCourses":
		echo json_encode(requestAllCourses($mysqli));
		break;
	case "requestCourse":
		$payload->datum = date("Y-m-d");
		$time = date("H:i:s");
		$courseInfo = requestCourse($mysqli, $payload);
		$courseInfo = checkCourseTime($courseInfo, $time);
		$courseInfo = checkCourseCount($courseInfo);
		echo json_encode($courseInfo);
		break;
	case "insertCourse":
		$updatedCourses = insertCourse($mysqli, $payload);
		echo json_encode($updatedCourses);
		break;
	default:
		# code...
		break;
}
