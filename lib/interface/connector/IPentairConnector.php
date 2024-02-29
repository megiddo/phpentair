<?php

include_once "PentairMessage.php";

interface IPentairConnector {

    public function open();
    public function close();
    public function read($bytes);
    public function put(PentairMessage $message);

}

class NotImplementedException extends BadMethodCallException {

}