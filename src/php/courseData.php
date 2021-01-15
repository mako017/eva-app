<?php

/**
 * This function is called to get all courses from the database
 * @param mysqli $mysqli A mysqli connection
 * @return array An array containing all courses
 */
function requestAllCourses($mysqli)
{
	$courses = [];
	$sql = $mysqli->prepare("SELECT * FROM `evabox_plan`");
	$sql->execute();
	$sql->store_result();
	$sql->bind_result($counter, $lsf, $titel, $datum, $raum, $von, $bis, $sitzung, $dozent, $liveFB, $optLink);
	while ($sql->fetch()) {
		$courses[] = (object) [
			"Counter" => $counter,
			"lsf" => $lsf,
			"titel" => $titel,
			"datum" => $datum,
			"raum" => $raum,
			"von" => $von,
			"bis" => $bis,
			"sitzung" => $sitzung,
			"dozent" => $dozent,
			"liveFB" => $liveFB === 1 ? true : false,
			"optLink" => $optLink,
		];
	}
	if (count($courses) == 0) {
		$courses[] = (object) [
			"Counter" => "NaN",
			"lsf" => "NaN",
			"titel" => "NaN",
			"datum" => "NaN",
			"raum" => "NaN",
			"von" => "NaN",
			"bis" => "NaN",
			"sitzung" => "NaN",
			"dozent" => "NaN",
			"liveFB" => "NaN",
			"optLink" => "NaN",
		];
	}
	return $courses;
}
/**
 * This function is called to get a single course from the database
 * @param mysqli $mysqli A mysqli connection
 * @return array An array containing all courses
 */
function requestCourse($mysqli, $payload)
{
	$courseinfo = [];
	$sql = $mysqli->prepare("SELECT `Counter`, `dozent`, `titel`, `sitzung`, `von`, `bis`, `optLink`, `liveFB` FROM `evabox_plan` WHERE `lsf` = ? AND `datum` = ?");
	$sql->bind_param("is", $payload->lsf, $payload->datum);
	$sql->execute();
	$sql->store_result();
	$sql->bind_result($counter, $doz, $titel, $sitzung, $von, $bis, $optLink, $liveFB);
	while ($sql->fetch()) {
		$courseinfo[] = (object) [
			"Counter" => $counter,
			"doz" => $doz,
			"titel" => $titel,
			"sitzung" => $sitzung,
			"von" => $von,
			"bis" => $bis,
			"optLink" => $optLink,
			"liveFB" => $liveFB == 1 ? true : false,
		];
	}
	if (count($courseinfo) == 0) {
		$courseinfo[] = (object) [
			"Counter" => 0,
			"doz" => "NaN",
			"titel" => "NaN",
			"sitzung" => "NaN",
			"von" => "NaN",
			"bis" => "NaN",
			"optLink" => "NaN",
			"liveFB" => "NaN",
		];
	}
	return $courseinfo;
}
/**
 * Takes a mysqli connection and a payload and enters a new line into the database
 * @param mysqli $mysqli A mysqli connection
 * @param object $courses An array containing all courses that need to be appended
 * @return array An array containing which course was entered correctly
 */
function insertCourse($mysqli, $courses)
{
	$success = [];
	$sql = $mysqli->prepare("INSERT INTO `evabox_plan` (`lsf`, `titel`, `datum`, `raum`, `von`, `bis`, `sitzung`, `dozent`, `liveFB`, `optLink`) 
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	foreach ($courses as $course) {
		$sql->bind_param("isssssssss", $course->lsf, $course->titel, $course->datum, $course->raum, $course->von, $course->bis, $course->sitzung, $course->dozent, $course->liveFB, $course->optLink);
		$sql->execute();
		if ($sql->affected_rows > 0) {
			$success[] = 1;
		} else {
			$success[] = 0;
		}
	}
	$sql->close();
	return $success;
}

/**
 * Takes a mysqli connection and a payload and enters a new line into the database
 * @param mysqli $mysqli A mysqli connection
 * @param object $courses An array containing all courses that need to be appended
 * @return array An array containing which course was entered correctly
 */
function removeCourse($mysqli, $courses)
{
	$success = [];
	$sql = $mysqli->prepare("DELETE FROM `evabox_plan` WHERE `Counter` = ? AND lsf = ?");
	foreach ($courses as $course) {
		$sql->bind_param("ii", $course->Counter, $course->lsf);
		$sql->execute();
		if ($sql->affected_rows > 0) {
			$success[] = 1;
		} else {
			$success[] = 0;
		}
	}
	$sql->close();
	return $success;
}
/**
 * Takes a mysqli connection and a payload and enters a new line into the database
 * @param mysqli $mysqli A mysqli connection
 * @param object $courses An array containing all courses that need to be appended
 * @return array An array containing which course was entered correctly
 */
function updateCourse($mysqli, $courses)
{
	$success = [];
	$sql = $mysqli->prepare("UPDATE `evabox_plan` SET 
	`titel`=?,`datum`=?,`raum`=?,`von`=?,`bis`=?,
	`sitzung`=?,`dozent`=?,`liveFB`=?,`optLink`=?
	 WHERE `Counter`=? AND `lsf`=?");
	foreach ($courses as $course) {
		$sql->bind_param(
			"sssssssssii",
			$course->titel,
			$course->datum,
			$course->raum,
			$course->von,
			$course->bis,
			$course->sitzung,
			$course->dozent,
			$course->liveFB,
			$course->optLink,
			$course->Counter,
			$course->lsf
		);
		$sql->execute();
		if ($sql->affected_rows > 0) {
			$success[] = 1;
		} else {
			$success[] = 0;
		}
	}
	$sql->close();
	return $success;
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
