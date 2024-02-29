<?php

declare(strict_types=1);

namespace App\Domain\Signal;

interface SignalRepository
{
    /**
     * @return Signal[]
     */
    public function findAll(): array;

    /**
     * @param int $count
     * @return Signal[]
     */
    public function mostRecent(int $count): array;
}
