<?php

include_once "../IPentairConnector.php";
include_once ""

class ElfinEW11Connector extends IPentairConnector {

    var $host;
    var $port;
    var $socket;

    public function __constructor($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    public function open() {
        this->socket = fsockopen($this->host, $this->port);
    }

    public function close() {
        fclose($this->socket);
    }

    public function read($bytes) {
        return fgetc($this->socket);
    }

    public function put(PentairMessage $message) {
        return fputs($message->getBytes());
    }

}