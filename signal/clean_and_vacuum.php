<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$signalDb = new SQLite3('/var/www/pentair/data/signal.sql3');
$signalDb->exec("CREATE TABLE IF NOT EXISTS signals (id INTEGER PRIMARY KEY AUTOINCREMENT, ts DATETIME DEFAULT CURRENT_TIMESTAMP, signal TEXT)");
$signalDb->exec("select * from signals where date(ts) < date('now', '-6 day')");
$signalDb->exec("VACUUM;");