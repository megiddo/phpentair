<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\Signal\SignalRepository;
use App\Domain\Configuration\ConfigurationRepository;

use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Signal\Sqlite3SignalRepository;
use App\Infrastructure\Persistence\Configuration\DotEnvConfigurationRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        ConfigurationRepository::class => \DI\autowire(DotEnvConfigurationRepository::class),
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        SignalRepository::class => \DI\autowire(Sqlite3SignalRepository::class)
    ]);
};
