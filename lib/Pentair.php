<?php

include_once "interface/PentairComFacade.php";

class Pentair {
    
    private $com;
    private $flock;
    private $readCache;

    function public __construct(PentairComFacade $com, $flock, $readCache) {
        $this->com = $com;
        $this->flock = $flock;
        $this->readCache = $readCache;
    }

    function read() {
        $fp = fopen($this->flock);

        if (flock($fp, LOCK_EX | LOCK_NB)) {
            file_put_contents($this->readCache, json_encode($this->com->read()));
            flock($fp, LOCK_UN);
        }
        flock($fp, LOCK_SH);
        $json = file_get_contents($this->readCache);
        flock($fp, LOCK_UN);

        fclose($fp);

        return new PentairMessage($json);
    }

    function write($message) {
        return $this->com->put($message);
    }

}