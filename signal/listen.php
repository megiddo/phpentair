<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$ew11 = new Phpentair\Com\EW11Connector('10.0.0.11', 8899);
$com = new \Phpentair\PentairComFacade($ew11);
$pentair = new Phpentair\Pentair($com);

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

do {
  try {
      $message = $pentair->read();
      echo date('Y-m-d H:i:s') . ":" . $message->toJson(JSON_PRETTY_PRINT) . "\n";
      if ($message->protocol > 0) {
        $stmt = $signalDb->prepare("INSERT INTO signals (`signal`) values (:signal)");
        $stmt->bindParam('signal', $message->raw);
        $insert = $stmt->execute();
        
        $signals = $signalDb->query('select * from signals order by id desc limit 1');
        echo json_encode($signals->fetchAll(PDO::FETCH_ASSOC)) . "\n";
      }
  } catch (Exception\EndOfStreamException $eose) {
      die("End of stream\n");
  } catch (\TypeError $te) {
      die("TE error " . $te->getMessage() . "\n");
  }
} while (true);

die();

