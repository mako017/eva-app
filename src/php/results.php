<?php

function requestSingleResult(mysqli $mysqli, $payload)
{
	$courseEva = [];
	$sql = $mysqli->prepare("SELECT `sessionCounter`, `datum`, `zeit`, `wertung` FROM `evabox_daten` WHERE `lsf` = ?");
	$sql->bind_param("i", $payload->lsf);
	$sql->execute();
	$sql->store_result();
	$sql->bind_result($sess, $datum, $zeit, $wertung);
	while ($sql->fetch()) {
		$courseEva[] = (object) [
			"session" => $sess,
			"datum" => $datum,
			"zeit" => $zeit,
			"wertung" => $wertung,
		];
	}
	if (count($courseEva) == 0) {
		$courseEva[] = (object) [
			"session" => 0,
			"datum" => "NaN",
			"zeit" => "NaN",
			"wertung" => 0,
		];
	}
	return $courseEva;
}
