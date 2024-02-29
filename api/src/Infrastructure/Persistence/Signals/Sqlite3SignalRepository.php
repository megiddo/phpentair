<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Signal;

use App\Domain\Signal\Signal;
use App\Domain\Signal\SignalRepository;

interface Sqlite3SignalRepository implements SignalRepository
{

    private string $signalDb;

    public function __construct($dbPath) {
        $this->signalDb = new SQLite3($dbPath);
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
        $res = $signalDb->query('select * from signals order by id desc limit $count');
        $signals = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $res[] = new Signal($row->id, $row->ts, $row->message);
        }

        return $signals;
    }
}
