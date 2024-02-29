<?php

include_once "IPentairConnector.php";

class PentairComFacade {

    var $ipc;
    var $parser;

    public function __construct(IPentairConnector $ipc) {
        $this->ipc = $ipc;
        $this->parser = new PentairMessageParser($this->ipc);
    }

    public function read() {
        $this->seekHeader();
        return $this->parser->parse();
    }

    public function put(PentairMessage $message) {
        $this->ipc->put($message);
    }

    private function seekHeader() {
        while ($this->ipc->read(1) != 0xFF) {
            while ($this->ipc->read(1), 1) == 0xFF) {
                if ($this->ipc->read(1), 2) == 0xAA0F) {
                    return true;
                }
            }
        }
    }
}