<?php

function checkuser($mysqli, $payload)
{
    $newUser = true;
    $sql = $mysqli->prepare("SELECT * FROM Evabox_Fingerprint WHERE lsf = ? AND fingerprint = ?");
    $sql->bind_param("is", $data->lsf, $data->fp);
    $sql->execute();
    if ($sql->affected_rows > 0) {
            $newUser = false;
    }
    if ($newUser) writeFingerprint($mysqli, $payload);
    return $newUser;
    $sql->close();
}

function writeFingerprint($mysqli, $data)
{
    $sql = $mysqli->prepare("INSERT INTO `Evabox_Fingerprint` (`lsf`) VALUES (?)");
    $sql->bind_param("i", $data->lsf);
    $sql->execute();
    if ($sql->affected_rows > 0) {
            echo "1";
    } else {
            exit('0');
    }
}