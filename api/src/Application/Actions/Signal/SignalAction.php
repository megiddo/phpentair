<?php

declare(strict_types=1);

namespace App\Application\Actions\Signal;

use App\Application\Actions\Action;
use App\Domain\Signal\SignalRepository;
use Psr\Log\LoggerInterface;

abstract class SignalAction extends Action
{
    protected SignalRepository $signalRepository;

    public function __construct(LoggerInterface $logger, SignalRepository $signalRepository)
    {
        parent::__construct($logger);
        $this->signalRepository = $signalRepository;
    }
}
