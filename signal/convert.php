<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$signal = file_get_contents('php://input');

$host = '172.22.0.1';
$port = '17306';
$db = 'signal';
$user = 'pentair';
$pass = 'pentair';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=17306;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$signalDb = new PDO($dsn, $user, $pass, $options);
$sqlite3 = new SQLite3('/var/www/pentair/data/sample.sql3');

$signals = $sqlite3->query('select id, ts, hex(signal) as signal from signals order by id desc');
while ($sqlite3Row = $signals->fetchArray(SQLITE3_ASSOC)) {
    var_dump($sqlite3Row);
    $stmt = $signalDb->prepare("INSERT INTO signals (ts, `signal`) values (:ts, :signal)");
    $stmt->bindParam('ts', $sqlite3Row['ts']);
    $stmt->bindParam('signal', $sqlite3Row['signal']);
    $insert = $stmt->execute();
}
