<?php

declare(strict_types=1);

namespace App\Application\Actions\Signal;

use Psr\Http\Message\ResponseInterface as Response;

class RecentSignalsAction extends SignalAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $signals = $this->signalRepository->mostRecent(1);

        $this->logger->info("Most recent signal was viewed.");

        return $this->respondWithData($signals);
    }
}
