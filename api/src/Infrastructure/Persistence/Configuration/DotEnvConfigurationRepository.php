<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Configuration;

use App\Domain\Configuration\ConfigurationRepository;

class DotEnvConfigurationRepository implements ConfigurationRepository
{

    public function __construct() {

    }

    public function __get(string $key): mixed {
        if ($key == 'signalsDbPath') {
            return '/var/www/pentair/data/sample.sql3';
        }
    }
}
