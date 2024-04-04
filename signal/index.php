<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$signal = bin2hex(file_get_contents('php://input'));

$host = '172.20.0.1';
$port = '17306';
$db   = 'signal';
$user = 'pentair';
$pass = 'pentair';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=17306;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$signalDb = new PDO($dsn, $user, $pass, $options);
if (strlen($signal) > 0) {
    $stmt = $signalDb->prepare("INSERT INTO signals (`signal`) values (:signal)");
    $stmt->bindParam('signal', $signal);
    $insert = $stmt->execute();
}
$signals = $signalDb->query('select * from signals order by id desc limit 3');

echo json_encode($signals->fetchAll(PDO::FETCH_ASSOC));

/*
CREATE TABLE `signals` (
  `ts` datetime NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signal` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15445 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
 */
