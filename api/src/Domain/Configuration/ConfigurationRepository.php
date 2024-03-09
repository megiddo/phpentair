<?php

declare(strict_types=1);

namespace App\Domain\Configuration;

interface ConfigurationRepository
{

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed;
}
