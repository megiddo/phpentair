<?php

include_once "connector/IPentairConnector.php";
include_once "PentairMessage.php";

class PentairMessageParser {
    var $ipc;

    public function __construct(IPentairConnector $ipc) {
        $this->ipc = $ipc;
    }

    public function parse() {
        $header = $this->ipc->read(5);
        $msgSize = hexdec($header[MessageBytes::LENGTH]);
        $message = $this->ipc->read($msgSize);
        $raw = 'ff00ffa5' . $header . $message;
        $pm = new PentairMessage();
        $pm->parse($raw);
        return $pm;
    }
}