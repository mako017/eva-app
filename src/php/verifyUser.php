<?php

function checkuser($mysqli, $payload)
{
	$newUser = true;
	$sql = $mysqli->prepare("SELECT * FROM evabox_fingerprint WHERE lsf = ? AND fingerprint = ?");
	$sql->bind_param("is", $payload->lsf, $payload->fp);
	$sql->execute();
	$sql->store_result();
	if ($sql->num_rows > 0) {
		$newUser = false;
		return $newUser;
	} else {
		$sql->close();
		writeFingerprint($mysqli, $payload);
		return $newUser;
	}
}

function writeFingerprint($mysqli, $payload)
{
	$sql = $mysqli->prepare("INSERT INTO `evabox_fingerprint` (`lsf`, `fingerprint`) VALUES (?, ?)");
	$sql->bind_param("is", $payload->lsf, $payload->fp);
	$sql->execute();
	if ($sql->affected_rows > 0) {
		echo "1";
	} else {
		exit("0");
	}
	$sql->close();
}
