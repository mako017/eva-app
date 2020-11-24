<?php

function requestCourse($mysqli, $payload)
{
	$courseinfo = [];
	$sql = $mysqli->prepare("SELECT * FROM `evabox_plan` WHERE `lsf` = ? AND `datum` = ?");
	$sql->bind_param("is", $payload->lsf, $payload->datum);
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$courseinfo[] = (object) [
				"doz" => $row["dozent"],
				"titel" => $row["titel"],
				"sitzung" => $row["sitzung"],
				"von" => $row["von"],
				"bis" => $row["bis"],
			];
		}
	} else {
		$courseinfo[] = (object) [
			"doz" => "NaN",
			"titel" => "NaN",
			"sitzung" => "NaN",
			"von" => "NaN",
			"bis" => "NaN",
		];
	}
	return $courseinfo;
}

/**
 * Takes an array of courses and checks which is being held
 * @param array $courseInfo An array containing different courses from the same day and course number
 * @param string $time The current time of format H:i:s
 * @return array Returns an array containing all courses that are being held at the moment
 */
function checkCourseTime($courseInfo, $time)
{
	$checkedArray = [];
	foreach ($courseInfo as $course) {
		if ($course->von < $time && addTime($course->bis, 15) > $time) {
			$checkedArray[] = $course;
		}
	}
	return $checkedArray;
}

/**
 * This function adds a number of minutes to a time string
 * @param string $time A string of format H:i:s
 * @param integer $minutes Any positive integer
 * @return string
 */
function addTime($time, $minutes)
{
	$newTime = date("H:i:s", strtotime("+" . $minutes . " minutes", strtotime($time)));
	return $newTime;
}

/**
 * This function tests whether a course array consists of 1 or more entries.
 * @param array $Arr An array of courses
 * @return object
 */
function checkCourseCount($Arr)
{
	$checkedCourse = (object) [];
	if (count($Arr) === 1) {
		$checkedCourse = $Arr[0];
	}
	return $checkedCourse;
}
