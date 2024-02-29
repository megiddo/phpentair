<?php

include_once "IPentairConnector.php";

class HexSampleConnector implements IPentairConnector {

    var $raw;
    var $currentByte;

    public function __constructor($fileName) {
        $this->raw = HexSampleConnector::sample2bin($fileName);
        $this->currentByte = 0;
    }

    public function open() {

    }

    public function close() {

    }

    public function read($bytes) {
        $read = substr($this->raw, $this->currentByte, $bytes);
        $this->currentByte += $bytes;
        return $read;
    }

    public function put(PentairMessage $message) {
        throw new NotImplementedException();
    }

    public static function sample2bin($file) {
        $hexlines = file($file);
        $bin = '';
        foreach ($hexlines as $hexline) {
            preg_match_all('/\s([0-9a-f]{2})/U', $hexline, $out);
            $hexplode = implode('', $out[1]);
            $bin .= hex2bin($hexplode);
        }
        return $bin;
    }
}
