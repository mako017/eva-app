<?php

public function writeData($mysqli, $data)
{
    $sql = $mysqli->prepare("INSERT INTO `Evabox_Daten` (`lsf`, `datum`, `zeit`, `wertung`) VALUES (?, ?, ?, ?)");
    $sql->bind_param("isss", $data->lsf, $data->datum, $data->zeit, $data->wertung);
    $sql->execute();
    if ($sql->affected_rows > 0) {
            echo "1";
    } else {
            exit('0');
    }
}