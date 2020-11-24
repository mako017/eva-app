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
 * @param time A string of format H:i:s
 * @param minutes Any positive integer
 * @return date
 */
function addTime($time, $minutes)
{
	$newTime = date("H:i:s", strtotime("+" . $minutes . " minutes", strtotime($time)));
	return $newTime;
}

/**
 * This function tests whether a course array consists of 1 or more entries.
 * @param Arr An array of courses
 * @return checkedCourse One single course object
 */
function checkCourseCount($Arr)
{
	$checkedCourse = (object) [];
	if (count($Arr) === 1) {
		$checkedCourse = $Arr[0];
	}
	return $checkedCourse;
}
