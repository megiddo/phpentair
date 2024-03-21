<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$signal = file_get_contents('php://input');

$signalDb = new SQLite3('/var/www/pentair/data/signal.sql3');

if (strlen($signal) > 0) {
    $stmt = $signalDb->prepare("INSERT INTO signals (signal) values (:signal)");
    $stmt->bindParam('signal', $signal);
    $insert = $stmt->execute();
}
$signals = $signalDb->query('select * from signals order by id desc limit 3');
echo json_encode($signals->fetchArray(SQLITE3_ASSOC));
