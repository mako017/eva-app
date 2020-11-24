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
		if ($course->von < $time && $course->bis > $time) {
			$checkedArray[] = $course;
		}
		return $checkedArray;
	}
}

function checkCourseCount($checkedArray)
{
	$checkedCourse = (object) [];
	if (count($checkedArray) === 1) {
		$checkedCourse = $checkedArray[0];
	}
	return $checkedCourse;
}
