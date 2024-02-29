<?php

enum MessageBytes {
    case SYNC_0 = 0;                // 0xff
    case SYNC_1 = 1;                // 0x00
    case SYNC_2 = 2;                // 0xff
    case SYNC_3 = 3;                // 0xa5
    case VERSION;
    case DST;
    case SRC;
    case OPCODE;
    case LEN = 8;                   // 0x1d (29)
    case HOURS = 9;
    case MINUTES = 10;
    case EQUIPMENT_0_1 = 11;
    case POOL_SET_TEMP = 12;        // sus
    case SPA_SET_TEMP = 13;         // sus
    case WATER_TEMP = 23;
    case HEATER_TEMP = 24;          
    case AIR_TEMP = 27;
    case TEMP_2 = 34;
    case TEMP_3 = 35;
}

enum EQUIPMENT1 {
    UNDEF = 0;
    JETS_1 = 1;
    JETS_2 = 2;
    SPILLWAY = 3;
    WATERFALL = 4;
    POOL_PUMP = 5;
    SLIDE = 6;
    POOL_LIGHT = 7;
}

enum EQUIPMENT2 {
    SPA_LIGHT = 0;
}

class PentairMessage {

    var $raw;
    var $version;
    var $destionation;
    var $source;
    var $opCode;
    var $infoFieldLength;
    var $minutes;
    var $hours;
    var $primaryEquipment;
    var $secondaryEquipment;
    var $waterTemperature;
    var $spaWaterTemperature;

    public function __construct($json = null) {

    }

    public function getBytes() {
        
    }

    public static function parse($raw) {
        $pm = new PentairMessage();
        $pm->raw($raw);
        $pm->version($pm->byte(MessageBytes::VERSION));
        $pm->destination($pm->byte(MessageBytes::DST));
        $pm->source($pm->byte(MessageBytes::SRC));
        $pm->opCode($pm->byte(MessageBytes::OPCODE));
        $pm->infoFieldLength($pm->byte(MessageBytes::LEN));
        $pm->minutes($pm->byte(MessageBytes::MINUTES));
        $pm->hours($pm->byte(MessageBytes::HOURS));
        return $pm;
    }

    public function byte($byte) {
        return hexdec($this->raw[$byte]);
    }

    public function __call($field, $value) {
        if (property_exists($this, $field)) {
            $this->$field = $value;
        }
    }
}