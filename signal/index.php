<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$signal = file_get_contents('php://input');

$signalDb = new SQLite3('/var/www/pentair/data/signal.sql3');
$signalDb->exec("CREATE TABLE IF NOT EXISTS signals (id INTEGER PRIMARY KEY AUTOINCREMENT, ts DATETIME DEFAULT CURRENT_TIMESTAMP, signal TEXT)");
$signalDb->exec("select * from signals where date(ts) < date('now', '-6 day')");
$signalDb->exec("VACUUM;");

$stmt = $signalDb->prepare("INSERT INTO signals (signal) values (:signal)");
$stmt->bindParam('signal', $signal);
$insert = $stmt->execute();
$signals = $signalDb->query('select * from signals order by id desc limit 1');
echo json_encode($signals->fetchArray(SQLITE3_ASSOC));
