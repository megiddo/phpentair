<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$host = '10.0.0.15';
$port = '17306';
$db   = 'signal';
$user = 'pentair';
$pass = 'pentair';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$signalDb = new PDO($dsn, $user, $pass, $options);

$signals = $signalDb->query('select * from signals order by id desc limit 30');

header('Content-Type: application/json; charset=utf-8');
echo json_encode($signals->fetchAll(PDO::FETCH_ASSOC)) . "\n";

die();

