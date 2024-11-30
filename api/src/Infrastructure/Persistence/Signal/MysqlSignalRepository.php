<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Signal;

use App\Domain\Signal\Signal;
use App\Domain\Signal\SignalRepository;
use App\Domain\Configuration\ConfigurationRepository;
use PDO;

class MysqlSignalRepository implements SignalRepository
{

    private PDO $signalDb;

    public function __construct(ConfigurationRepository $config) {
        $dsn = "mysql:host=$_ENV[host];port=$_ENV[port];dbname=$_ENV[db];charset=$_ENV[charset]";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->signalDb = new PDO($dsn, $_ENV['user'], $_ENV['pass'], $options);
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
        $res = $this->signalDb->query('select id, ts, `signal` as `signal` from signals order by id desc limit ' . $count);
        $signals = [];
        $results = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $row) {
            $signals[] = new Signal($row['id'], new \DateTime($row['ts']), $row['signal']);
        }

        return $signals;
    }
}
