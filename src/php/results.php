<?php

function requestSingleResult($mysqli, $payload)
{
	$courseEva = [];
	$sql = $mysqli->prepare("SELECT `sessionCounter`, `datum`, `zeit`, `wertung` FROM `evabox_daten` WHERE `lsf` = ?");
	$sql->bind_param("i", $payload->lsf);
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$courseEva[] = (object) [
				"session" => $row["sessionCounter"],
				"datum" => $row["datum"],
				"zeit" => $row["zeit"],
				"wertung" => $row["wertung"],
			];
		}
	} else {
		$courseEva[] = (object) [
			"session" => 0,
			"datum" => "NaN",
			"zeit" => "NaN",
			"wertung" => 0,
		];
	}
	return $courseEva;
}
