<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Signal;

use App\Domain\Signal\Signal;
use App\Domain\Signal\SignalRepository;
use App\Domain\Configuration\ConfigurationRepository;
use SQLite3;
use DateTime;

class Sqlite3SignalRepository implements SignalRepository
{

    private \SQLite3 $signalDb;

    public function __construct(\App\Domain\Configuration\ConfigurationRepository $config) {
        $this->signalDb = new \SQLite3($config->signalsDbPath);
    }

    /**
     * @return Signal[]
     */
    public function findAll(): array {

    }

    /**
     * @param int $count
     * @return Signal[]
     */
    public function mostRecent(int $count): array {
        $res = $this->signalDb->query('select id, ts, hex(signal) as signal from signals order by id desc limit ' . $count);
        $signals = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $signals[] = new Signal($row['id'], new \DateTime($row['ts']), $row['signal']);
        }

        return $signals;
    }
}
