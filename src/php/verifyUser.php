<?php

function checkuser($mysqli, $payload)
{
	$newUser = true;
	$sql = $mysqli->prepare("SELECT * FROM evabox_fingerprint WHERE lsf = ? AND sessionCounter = ? AND fingerprint = ?");
	$sql->bind_param("iis", $payload->lsf, $payload->session, $payload->fp);
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
	$sql = $mysqli->prepare("INSERT INTO `evabox_fingerprint` (`lsf`, `sessionCounter`, `fingerprint`) VALUES (?, ?, ?)");
	$sql->bind_param("iis", $payload->lsf, $payload->session, $payload->fp);
	$sql->execute();
	if ($sql->affected_rows > 0) {
		echo "1";
	} else {
		exit("0");
	}
	$sql->close();
}

function signIn(mysqli $mysqli, $payload)
{
	$token = "invalid";
	$sql = $mysqli->prepare("SELECT password FROM evabox_users WHERE name = ?");
	$sql->bind_param("s", $payload->user);
	$sql->execute();
	$sql->store_result();
	$sql->bind_result($password);
	$sql->fetch();
	if ($password !== null) {
		if (password_verify($payload->password, $password)) {
			$token = base64_encode(random_bytes(128));
			$token = strtr($token, "+/", "-_");
			$_SESSION["token"] = $token;
		}
	}
	$sql->close();
	return $token;
}
