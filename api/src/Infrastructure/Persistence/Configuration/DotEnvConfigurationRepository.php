<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Configuration;

use App\Domain\Configuration\ConfigurationRepository;

class DotEnvConfigurationRepository implements ConfigurationRepository
{
    private \Dotenv\Dotenv $dotenv;

    public function __construct() {
        $dotenvPath = $_ENV['DOTENV_PATH'] ?? '/var/www/pentair/data';
        $this->dotenv = \Dotenv\Dotenv::createImmutable($dotenvPath);
        $this->dotenv->load();
    }

    public function __get(string $key): mixed {
        return $_ENV[$key];
    }
}
