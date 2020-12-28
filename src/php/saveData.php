<?php

function writeData($mysqli, $data)
{
	$sql = $mysqli->prepare("INSERT INTO `evabox_daten` (`lsf`, `sessionCounter`, `datum`, `zeit`, `wertung`) VALUES (?, ?, ?, ?, ?)");
	$sql->bind_param("iissi", $data->lsf, $data->session, $data->datum, $data->zeit, $data->wertung);
	$sql->execute();
	if ($sql->affected_rows > 0) {
		//     echo "1";
	} else {
		exit("0");
	}
	$sql->close();
}
